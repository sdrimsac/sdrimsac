<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        title="Lista de productos A Vender"
        close-on-click-modal
        width="50%"
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
                            >
                                {{ item.food.item.description }}
                            </td>
                            <td
                                style="padding: 12px 15px; border-bottom: 1px solid #ddd;"
                            >
                                {{ item.price }}
                            </td>
                            <td
                                style="padding: 12px 15px; border-bottom: 1px solid #ddd;"
                            >
                                {{ item.quantity }}
                            </td>
                            <td
                                style="padding: 12px 15px; border-bottom: 1px solid #ddd;"
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
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 16px 0;
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
</style>
