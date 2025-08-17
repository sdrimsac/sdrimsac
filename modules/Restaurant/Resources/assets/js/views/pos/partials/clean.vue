<template>
    <el-dialog
        title="Habitaciones Para Limpiar"
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
                        <td>{{ table.number }}</td>
                        <td>{{ table.time_to_finish }}</td>
                        
                        <td>
                            <el-button
                                type="danger"
                                size="mini"
                                round
                                @click="onClean(table)"
                            >Limpiar</el-button>
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
        tablesClean: { type: Array, default: () => [] }
    },
    methods: {
        close() {
            // Cierra el modal informando al padre
            this.$emit("update:showDialog", false);
        },
        onClean(table) {
            // Notifica al padre para ejecutar la limpieza de la habitación/mesa
            // Se emiten dos eventos por compatibilidad: camelCase y kebab-case
            this.$emit("cleanTable", table);
            this.$emit("clean-table", table);
        }
    }
};
</script>