<template>
    <el-dialog title="Lotes" @open="open" @close="close" :visible="showDialog">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lote</th>
                    <th>Vencimiento</th>
                    <th>Cantidad</th>
                    <th width="20%">Seleccionado</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(lote, idx) in lotes" :key="idx">
                    <td>{{ idx + 1 }}</td>
                    <td>{{ lote.code }}</td>
                    <td>{{ lote.date_of_due }}</td>
                    <td>{{ lote.quantity }}</td>
                    <td>
                        <el-input
                            @input="checkStock(idx)"
                            v-model="lote.quantitySelected"
                        >
                        </el-input>
                    </td>
                </tr>
            </tbody>
        </table>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cerrar</el-button>
            <el-button type="primary" @click="save">Guardar</el-button>
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
            if (this.orden) {
                this.lotes = this.orden.lotes;
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
