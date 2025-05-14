<template>
    <el-dialog
        :title="`Previsualización`"
        :visible.sync="showOpenOrden"
        width="80%"
        :close-on-click-modal="false"
        :before-close="close"
        :append-to-body="true"
        :destroy-on-close="true"
    >
    <div class="card">
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Total</th>
                    </tr>

                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        <td class="text-center">{{ item.description }}</td>
                        <td class="text-center">{{ item.price }}</td>
                        <td class="text-center">{{ item.quantity }}</td>
                        <td class="text-center">{{ item.total }}</td>
                    </tr>

                </tbody>
                
            </table>

        </div>

    </div>

    </el-dialog>
</template>
<script>
export default {
    props: ["showDialog", "items"],
    data() {
        return {
            loading: false
        };
    },
    methods: {
        close() {
            this.$emit("close");
        }
    }
};
</script>