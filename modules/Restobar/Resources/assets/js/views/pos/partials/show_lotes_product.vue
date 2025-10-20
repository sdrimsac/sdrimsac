<!-- Modal de Lotes en Caja -->

<template>
    <el-dialog title="Seleccion el Lote del Producto" @open="open" @close="close" :visible="showDialog">
        <table class="table">
            <thead>
                <tr style="background-color: #073f68; color: #fff;">
                    <th style="color: #fff;">#</th>
                    <th style="color: #fff;">Lote</th>
                    <th style="color: #fff;">Vencimiento</th>
                    <th class="text-center" style="color: #fff;">Stock</th>
                    <th width="10%" style="color: #fff;">Unidades</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(lote, idx) in lotes"
                    :key="idx"
                    :style="{ backgroundColor: idx % 2 === 0 ? '#fff' : '#afafaf' }"
                >
                    <td>{{ idx + 1 }}</td>
                    <td>{{ lote.code.toUpperCase() }}</td>
                    <td>{{ lote.date_of_due }}</td>
                    <td class="text-center">{{ lote.quantity }}</td>
                    <td>
                        <el-input
                            @input="checkStock(idx)"
                            @focus="lote.quantitySelected = ''"
                            v-model="lote.quantitySelected"
                        >
                        </el-input>
                    </td>
                </tr>
            </tbody>
        </table>
        <span slot="footer" class="dialog-footer" style="display: flex; justify-content: flex-end;">
            <el-button class="btn_cancelarsmall" type="primary" @click="close">
            <i class="el-icon-arrow-left"></i> Cerrar
            </el-button>
            <el-button class="btn_guardarsmall" type="primary" @click="save" style="margin-left: 8px;">
            <i class="el-icon-plus"></i> Agregar
            </el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "idx", "orden"],
    data() {
        return {
            lotes: []
        };
    },

    methods: {
        save() {
            this.$emit("updateLotes", this.idx, this.lotes);
            this.close();
        },
        open() {
            if (this.orden && Array.isArray(this.orden.lotes)) {
                // Copia profunda y reactiva
                this.lotes = this.orden.lotes.map(lote => ({
                    ...lote,
                    quantitySelected: lote.quantitySelected || ''
                }));
            }
        },
        checkStock(idx) {
            let lote = this.lotes[idx];
            if (lote.quantitySelected > lote.quantity) {
                this.lotes[idx].quantitySelected = lote.quantity;
                this.$toast.warning("Limite sobrepasado");
            }
            if (0 > lote.quantitySelected) {
                this.$toast.warning("Numero invalido");
                this.lotes[idx].quantitySelected = 1;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getLotes() {}
    }
};
</script>
