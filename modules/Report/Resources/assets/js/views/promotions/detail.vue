<template>
    <el-dialog :visible="showDialog" append-to-body @open="open" @close="close"
        :title="`Productos recibidos | ${customer_name}`" width="80%">
        <div class="card-header">
            <div>
                <el-button type="primary" @click="downloadPDF">Descargar PDF</el-button>
            </div>
        </div>
        <div class="row m-2">
            <table class="table table-bordered" v-loading="loading">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th v-if="isPromotionPoints">Puntos unitarios</th>
                        <th v-if="isPromotionPoints">Puntos totales</th>
                        <th>Fecha</th>
                        <th>Vendedor</th>
                    </tr>
                </thead>

                <tbody>
                    <template v-if="receiveds.length > 0">
                        <tr v-for="(received, idx) in receiveds" :key="received.id">
                            <td>{{ idx + 1 }}</td>
                            <td>
                                <img :src="received.image_url" alt="Imagen del producto" width="50" />
                            </td>
                            <td>{{ received.product }}</td>
                            <td>{{ received.quantity }}</td>
                            <td v-if="isPromotionPoints">
                                {{ received.unit_points }}
                            </td>
                            <td>
                                {{ received.total_points }}
                            </td>
                            <td>
                                {{ received.date }} <br /><small>{{
                                    received.time
                                }}</small>
                            </td>
                            <td>{{ received.seller }}</td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="7" class="text-center">
                                No hay productos canjeados
                            </td>
                        </tr>
                    </template>
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
            receiveds: [],
            customer_name: null,
            loading: false
        };
    },
    methods: {
        getRecord() {
            this.loading = true;
            this.$http
                .get(`/reports/promotions/detail/${this.currentRow.id}`)
                .then(({ data }) => {
                    console.log("la data: ", data);
                    if (data.success) {
                        this.document_customer = data.document_customer;
                        this.receiveds = data.receiveds;
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        open() {
            this.customer_name = this.currentRow.customer_name;
            this.getRecord();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        downloadPDF() {
            const url = `/reports/pdf-points/${this.currentRow.id}`;
            window.open(url, "_blank");
        }
    }
};
</script>