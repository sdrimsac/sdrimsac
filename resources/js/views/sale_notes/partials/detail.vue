<template>
    <el-dialog
        v-loading="loading"
        :visible="showDialog"
        @open="open"
        @close="close"
        :title="`Detalle ${number}`"
    >
        <div class="card" v-if="items.length != 0">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th class="text-right">Cantidad</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, idx) in items" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td>{{ data.item.description }}</td>
                        <td class="text-right">{{ Number(data.quantity) }}</td>
                        <td class="text-right">
                            {{ Number(data.total).toFixed(2) }}
                        </td>
                    </tr>
                    <td></td>
                    <td></td>
                    <td class="text-right">Total</td>
                    <td class="text-right">{{ totalItems.toFixed(2) }}</td>
                </tbody>
            </table>
            <span class="h3 m-2">Pagos</span>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th colspan="2">Método</th>
                        <th class="text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(data, idx) in boxes" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td colspan="2">{{ data.method }}</td>

                        <td class="text-right">
                            {{ Number(data.amount).toFixed(2) }}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2">Total</td>
                        <td class="text-right">{{ totalBoxes.toFixed(2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>Nota de venta sin productos</p>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "saleNoteId", "number", "boxes"],
    data() {
        return {
            loading: false,
            items: [],
            totalItems: 0,
            totalBoxes: 0
        };
    },
    methods: {
        close() {
            this.$emit("update:showDialog", false);
        },
        init() {
            this.totalItems = 0;
            this.totalBoxes = 0;
            this.items = [];
        },
        async open() {
            this.init();
            this.boxes.forEach(box => {
                this.totalBoxes += Number(box.amount);
            });
            try {
                this.loading = true;
                const response = await this.$http(
                    `/sale-notes/items/${this.saleNoteId}`
                );
                const {
                    data: { items }
                } = response;
                this.items = items;
                this.items.forEach(item => {
                    this.totalItems += Number(item.total);
                });
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
