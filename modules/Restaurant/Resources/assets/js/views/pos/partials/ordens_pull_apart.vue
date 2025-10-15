<template>
    <el-dialog
        :visible="showPullApart"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        title="Ventas Aparcadas"
        @close="close"
        @open="open"
        :width="'50%'"
    >
        <div class="">
            <div v-if="ordenInBox.length > 0" class="table-responsive">
                <table class="table table-hover align-middle shadow-sm rounded">
                    <thead style="background: #1e5a85; color: #fff;">
                        <tr>
                            <th style="color: #fff;">#</th>
                            <th class="text-center" style="color: #fff;">Referencia</th>
                            <th class="text-center" style="color: #fff;">Nro. Pedidos</th>
                            <th class="text-center" style="color: #fff; width: 180px;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(aparted, idx) in ordenInBox" :key="idx" style="background: #f9fbfc;">
                            <td class="fw-bold">{{ idx + 1 }}</td>
                            <td class="text-center">{{ aparted.ref }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary fs-6">{{ aparted.ordens.length }}</span>
                            </td>
                            <td class="text-center">
                                <el-tooltip content="Restaurar Venta" placement="top">
                                    <el-button
                                        type="primary"
                                        size="small"
                                        circle
                                        @click="restoreOrden(aparted)"
                                        style="margin-right: 8px;"
                                    >
                                        <i class="el-icon-refresh"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Eliminar Venta Aparcada" placement="top">
                                    <el-button
                                        type="danger"
                                        size="small"
                                        circle
                                        @click="removeApart(aparted.ref)"
                                     >
                                        <i class="el-icon-delete"></i>
                                    </el-button>
                                </el-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center" v-else>
                <span>Sin ventas aparcadas</span>
            </div>
        </div>
        <div class="p-2 d-flex justify-content-end">
            <button type="button" class="btn_cancelarsmall" @click="close">
                <i class="el-icon-close"></i>
                Cerrar
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
