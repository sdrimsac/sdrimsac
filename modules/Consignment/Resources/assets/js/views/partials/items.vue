<template>
    <el-dialog
        :visible="showDialog"
        title="Productos"
        append-to-body
        @open="open"
        @close="close"
        v-loading="loading"
    >
        <div class="row">
            <table class="table table-responsive table-stripe">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>
                            {{ item.name }}
                            <template v-if="item.has_lots">
                                <br />
                                <small>
                                    <a href="#" @click="clickShowLots(item)">
                                        Ver series
                                    </a>
                                </small>
                            </template>
                        </td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.price }}</td>
                        <td>{{ item.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <items-lot-view
            :showDialog.sync="showDialogItemsLot"
            :recordId="itemId"
        ></items-lot-view>
    </el-dialog>
</template>

<script>
const ItemsLotView = () => import("./lot_item_view.vue");
export default {
    components: {
        ItemsLotView
    },
    props: ["showDialog", "recordId"],
    data() {
        return {
            form: {},
            items: [],
            loading: false,
            showDialogItemsLot: false,
            itemId: null
        };
    },
    methods: {
        clickShowLots(item) {
            this.itemId = item.id;
            this.showDialogItemsLot = true;
        },
        async getItems() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/consignment/items/${this.recordId}`
                );
                console.log(response);
                if (response.status == 200) {
                    this.items = response.data.items;
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Error al obtener los productos");
            } finally {
                this.loading = false;
            }
        },
        open() {
            this.getItems();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
