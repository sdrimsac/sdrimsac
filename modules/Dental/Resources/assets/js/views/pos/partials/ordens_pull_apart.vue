<template>
    <el-dialog
        :visible="showPullApart"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        title="Ventas Aparcadas"
        @close="close"
        @open="open"
    >
        <div class="">
            <table v-if="ordenInBox.length > 0" class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th class="text-center">
                            DNI / Referencia
                        </th>
                        <th class="text-center">
                            Cantidad
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(aparted, idx) in ordenInBox" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td class="text-center">{{ aparted.ref }}</td>
                        <td class="text-center">{{ aparted.ordens.length }}</td>
                        <td class="text-center">
                            <el-button
                                type="success"
                                @click="restoreOrden(aparted)"
                            >
                                Restaurar
                            </el-button>

                            <el-button
                                type="danger"
                                @click="removeApart(aparted.ref)"
                            >
                                Eliminar
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-center" v-else>
                <span>Sin ventas aparcadas</span>
            </div>
        </div>
        <div class="p-2 d-flex justify-content-end">
            <button type="button" class="btn btn-light" @click="close">
                CERRAR
            </button>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: ["ordenInBox", "showPullApart"],
    methods: {
        open() {},
        close() {
            this.$emit("update:showPullApart", false);
        },
        async restoreOrden(ordens) {
            let res = await this.$confirm(
                "Desea restaurar la venta?",
                "Cancelar",
                {
                    confirmButtonText: "Ok",
                    cancelButtonText: "Cancelar",
                    type: "success"
                }
            );

            if (res) {
                let ref = ordens.ref;
                this.removeFromStorage(ref);
                this.$emit("restoreToLocalOrdens", ordens.ordens);
                this.close();
            }
        },
        async removeApart(ref) {
            let res = await this.$confirm(
                "Desea eliminar la venta?",
                "Cancelar",
                {
                    confirmButtonText: "Ok",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            );
            if (res) {
                this.removeFromStorage(ref);
                this.$toast.success("Venta eliminada");
                if (newApart.length == 0) {
                    this.close();
                }
            }
        },

        removeFromStorage(ref) {
            let newApart = this.ordenInBox.filter(f => f.ref != ref);
            localStorage.ordens = JSON.stringify(newApart);
            this.$emit("update:ordenInBox", newApart);
        }
    }
};
</script>
