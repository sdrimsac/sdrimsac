<template>
    <el-dialog
        :visible="showDialog"
        append-to-body
        @open="open"
        @close="close"
        title="Productos recibidos"
        width="80%"
    >
        <div class="row mt-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th v-if="isPromotionPoints">Puntos</th>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(received, idx) in receiveds" :key="received.id">
                        <td>{{ idx + 1 }}</td>
                        <td>{{ received.product }}</td>
                        <td>{{ received.quantity }}</td>
                        <td v-if="isPromotionPoints">-{{ received.points }}</td>
                        <td>
                            {{ received.date }} <br /><small>{{
                                received.time
                            }}</small>
                        </td>
                        <td>{{ received.seller }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["currentRow", "showDialog", "isPromotionPoints"],
    data() {
        return {
            form: {},
            document_customer: null,
            receiveds: []
        };
    },
    methods: {
        getRecord() {
            this.$http
                .get(`/reports/promotions/detail/${this.currentRow.id}`)
                .then(({ data }) => {
                    console.log("la data: ", data);
                    if (data.success) {
                        this.document_customer = data.document_customer;
                        this.receiveds = data.receiveds;
                    }
                });
        },
        open() {
            this.getRecord();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
