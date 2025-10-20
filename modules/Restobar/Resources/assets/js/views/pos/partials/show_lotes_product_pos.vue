<!-- Modal de Lotes para POS, muestra nombre, código, precio y lotes -->
<template>
    <el-dialog :title="'Selecciona el lote para ' + nombre" @open="open" @close="close" :visible="showDialog">
        <div style="margin-bottom: 12px;">
            <strong>Código:</strong> {{ codigo }}<br>
            <strong>Nombre:</strong> {{ nombre }}<br>
            <strong>Precio:</strong> S/ {{ precio }}
        </div>
        <table class="table">
            <thead>
                <tr style="background-color: #073f68; color: #fff;">
                    <th>#</th>
                    <th>Lote</th>
                    <th>Vencimiento</th>
                    <th class="text-center">Stock</th>
                    <th width="10%">Unidades</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(lote, idx) in lotes" :key="idx" :style="{ backgroundColor: idx % 2 === 0 ? '#fff' : '#afafaf' }">
                    <td>{{ idx + 1 }}</td>
                    <td>{{ lote.code.toUpperCase() }}</td>
                    <td>{{ lote.date_of_due }}</td>
                    <td class="text-center">{{ lote.quantity }}</td>
                    <td>
                        <el-input @input="checkStock(idx)" @focus="lote.quantitySelected = ''" v-model="lote.quantitySelected"></el-input>
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
    props: {
        showDialog: Boolean,
        nombre: String,
        codigo: String,
        precio: [String, Number],
        lotes: Array
    },
    data() {
        return {
            lotesLocal: []
        };
    },
    methods: {
        open() {
            // Copia profunda y reactiva de lotes
            this.lotesLocal = (this.lotes || []).map(lote => ({
                ...lote,
                quantitySelected: lote.quantitySelected || ''
            }));
        },
        checkStock(idx) {
            let lote = this.lotesLocal[idx];
            if (lote.quantitySelected > lote.quantity) {
                this.lotesLocal[idx].quantitySelected = lote.quantity;
                this.$toast && this.$toast.warning("Limite sobrepasado");
            }
            if (0 > lote.quantitySelected) {
                this.$toast && this.$toast.warning("Numero invalido");
                this.lotesLocal[idx].quantitySelected = 1;
            }
        },
        close() {
            this.$emit('update:showDialog', false);
        },
        save() {
            // Emitir todos los datos necesarios al padre
            this.$emit('agregarProductoConLotes', {
                nombre: this.nombre,
                codigo: this.codigo,
                precio: this.precio,
                lotes: this.lotesLocal.filter(l => l.quantitySelected > 0)
            });
            this.close();
        }
    }
};
</script>
