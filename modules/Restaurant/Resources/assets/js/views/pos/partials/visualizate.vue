<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        title="Lista de productos A Vender"
        close-on-click-modal
        width="60%"
    >
        <div class="card">
            <div class="card-body">
                <table>
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in localOrden"
                            :key="index"
                            :style="{
                                backgroundColor:
                                    index % 2 === 0 ? '#f9f9f9' : '#fff',
                                transition: 'background-color 0.3s ease'
                            }"
                        >
                            <td
                                style="padding: 12px 15px; border-bottom: 1px solid #ddd;"
                                :data-label="'Descripción'"
                            >
                                {{ item.food.item.description }}
                            </td>
                            <td
                                style="padding: 12px 15px; border-bottom: 1px solid #ddd;"
                                :data-label="'Precio'"
                            >
                                {{ item.price }}
                            </td>
                            <td
                                style="padding: 12px 15px; border-bottom: 1px solid #ddd;"
                                :data-label="'Cantidad'"
                            >
                                {{ item.quantity }}
                            </td>
                            <td
                                style="padding: 12px 15px; border-bottom: 1px solid #ddd;"
                                :data-label="'Total'"
                            >
                                {{ (item.price * item.quantity).toFixed(2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: ["showDialog","localOrden"],
    data() {
        return {
            imput: ""
        };
    },
    methods: {
        open() {
            console.log("Dialog opened", this.localOrden);
        },

        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
<style scoped>
.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-body {
    padding: 16px;
    overflow-x: auto; /* Permite scroll horizontal en móviles */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 16px 0;
    min-width: 400px; /* Evita que la tabla se comprima demasiado */
}

thead th {
    background-color: #f4f4f4;
    color: #333;
    font-weight: bold;
    padding: 12px;
    border: 1px solid #ddd;
}

tbody td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Responsividad para pantallas pequeñas */
@media (max-width: 600px) {
    .el-dialog {
        width: 98vw !important;
        min-width: unset !important;
        max-width: 100vw !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .card-body {
        padding: 4px;
        max-height: 50vh;
        overflow-y: auto;
        margin-top: 8px;
    }
    table,
    thead,
    tbody,
    th,
    td,
    tr {
        display: block;
        width: 100%;
    }
    thead {
        display: none;
    }
    tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #eee;
    }
    td {
        text-align: left;
        padding-left: 0;
        position: relative;
        min-height: 40px;
        border: none;
        border-bottom: 1px solid #ddd;
        word-break: break-word;
    }
    td:before {
        display: block;
        position: static;
        width: 100%;
        min-width: unset;
        max-width: unset;
        white-space: pre-line;
        font-weight: bold;
        text-align: left;
        content: attr(data-label);
        padding: 0 0 2px 0;
        margin-bottom: 2px;
        overflow: visible;
        text-overflow: unset;
    }
    table {
        font-size: 13px;
        min-width: unset;
        overflow-x: auto;
    }
    thead th, tbody td {
        padding: 6px 4px;
    }
}
</style>
