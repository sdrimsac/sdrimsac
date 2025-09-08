<template>
    <el-dialog
        title="Habitaciones Vencidos"
        :visible="showDialog"
        width="30%"
        append-to-body
        @close="close"
    >
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Habitación</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="table in tablesClean" :key="table.id || table.name">
                        <td>{{ table.number }}-{{ table.floor.tower.name }}</td>
                        <td>{{ table.time_to_finish }}</td>
                        
                        <td>
                            <el-button
                                type="primary"
                                size="mini"
                                round
                                @click="tableOpen(table.id)"
                            >HABITACIÓN</el-button>
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

    </el-dialog>
</template>

<script>
export default {
    name: "CleanModal",
    props: {
        showDialog: { type: Boolean, default: false },
        tablesClean: { type: Array, default: () => [] },
        cashId: { type: Number, default: null }
    },
    methods: {
        close() {
            // Cierra el modal informando al padre
            this.$emit("update:showDialog", false);
        },
        /* async tableOpen(id) {
            if (!this.cashId) {
                this.$message({
                    showClose: true,
                    type: "warning",
                    message: "Seleccione una caja para poder abrir una mesa"
                });
                return;
            }
            this.roomSeeId = id;
            this.openTablesRooms(id);
        }, */
        tableOpen(id) {
            // Notifica al padre para abrir la habitación
            this.$emit("openRoom", id);
        }

        /* onClean(table) {
            // Notifica al padre para ejecutar la limpieza de la habitación/mesa
            // Se emiten dos eventos por compatibilidad: camelCase y kebab-case
            this.$emit("cleanTable", table);
            this.$emit("clean-table", table);
        } */
    }
};
</script>