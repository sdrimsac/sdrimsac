<template>
    <el-dialog
        v-loading="loading"
        @open="open"
        @close="close"
        :visible="showDialog"
        title="Lista de Consignaciones"
        width="80%"
    >
        <div class="row mt-2"></div>
        <div class="row mt-2">
            <table class="table table-responsive table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha de consignación</th>
                        <th>Fecha de liquidación</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Penalidad</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(consignment, idx) in records" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td>{{ consignment.person.name }}</td>
                        <td>{{ consignment.date_of_issue }}</td>
                        <td>{{ consignment.date_of_end }}</td>
                        <td>
                            <el-button
                                type="primary"
                                icon="el-icon-search"
                                @click="clickShowProducts(consignment)"
                                >{{ consignment.stock }}</el-button
                            >
                        </td>
                        <td>{{ consignment.total }}</td>
                        <td>
                            {{ consignment.penalty }}
                        </td>
                        <td>
                            <el-button
                                @click="clickFormat(consignment.id)"
                                type="primary"
                            >
                                <i class="el-icon-s-order"></i>
                            </el-button>
                        </td>
                        <td>
                            <el-button
                                v-if="!consignment.liquidated"
                                @click="clickLiquidate(consignment)"
                                type="success"
                            >
                                <i class="el-icon-cash"></i>
                                Liquidar
                            </el-button>
                            <span v-else>
                                Liquidado
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <items-modal
                :showDialog.sync="showDialogItems"
                :recordId="recordId"
            >
            </items-modal>
        </div>
    </el-dialog>
</template>

<script>
const ItemsModal = () =>
    import(
        "../../../../../../../Consignment/Resources/assets/js/views/partials/items.vue"
    );
export default {
    props: ["showDialog"],
    components: {
        ItemsModal
    },
    data() {
        return {
            loading: false,
            showDialogItems: false,
            showDialogDetail: false,
            recordId: null,
            form: {},
            records: [],
            loading_search: false,
            resource: "/consignment",
            pagination: {}
        };
    },
    methods: {
        clickFormat(id) {
            window.open(`/consignment/format/${id}`, "_blank");
        },
        async clickDetail(consignment) {
            this.recordId = consignment.id;
            this.showDialogDetail = true;
        },
        async clickLiquidate(consignment) {
            const response = await this.$http(
                `${this.resource}/liquidate/${consignment.id}`
            );
            if (response.status == 200) {
                if (response.data.success) {
                    let { foods } = response.data;
                    foods = foods.map(food => {
                        food.toWarehouse = 0;
                        food.originalQuantity = food.quantity;
                        
                        return food;
                    });
                    this.$emit("setItemsToLiquidate", foods, consignment.id);
                    this.close();
                } else {
                    this.$toast.error(response.data.message);
                }
            }else{
                this.$toast.error("Ocurrió un error al liquidar la consignación");
            }
        },
        clickShowProducts(consignment) {
            this.recordId = consignment.id;
            this.showDialogItems = true;
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(`${this.resource}/records`);
                console.log(response);
                this.records = response.data.data;
            } catch (e) {
                this.$toast.error(e.message);
            } finally {
                this.loading = false;
            }
        },
        open() {
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
