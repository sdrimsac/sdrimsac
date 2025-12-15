<template>
    
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de promociones</h6>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table 
                :isFromAdmin="true"
                :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th>Cliente</th>
                        <th>
                            Promoción
                        </th>
                        <th v-if="isPromotionPoints">Puntos</th>
                        <th v-else>Monto</th>
                        <th>productos por canjear</th>
                        <th>Productos canjeados</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.customer_name }}</td>
                        <td>{{ row.promotion_name }}</td>
                        <td v-if="isPromotionPoints">{{ row.points }}</td>
                        <td v-else>{{ row.acc_total }}</td>
                        <td>
                            <button v-if="row.active == true" class="btn btn-sm btn-success" @click="showPoints(row.customer_id, row.customer_name)">Item disponibles</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" @click="showDetail(row)">Ver detalle</button>
                        </td>
                    </tr>
                </data-table>
            </div>
        </div>
        <detail
        :isPromotionPoints="isPromotionPoints"
        :current-row="currentRow" :show-dialog.sync="showDetailDialog"></detail>

    <points :show-dialog.sync="showPointsDialog" :customer-id="currentRow ? currentRow.customer_id : null" :current-row="currentRow"></points>
    </div>
</template>

<script>
import Detail from "./detail.vue";
import DataTable from "../../components/DataTableReportsPromotions.vue";
import Points from "./points.vue";

export default {
    props: ['configuration'],
    components: { DataTable, Detail, Points },
    data() {
        return {
            resource: "reports/promotions",
            form: {},
            currentRow: null,
            showDetailDialog: false,
            customer_name: null,
            showPointsDialog: false,
        };
    },
    computed: {
        isPromotionPoints() {
            return this.configuration.promotions_by_points;
        }
    },
    async created() {},
    methods: {
        showDetail(row) {
            this.currentRow = row;
            this.showDetailDialog = true;
        },

        showPoints(customerId, customerName) {
            this.currentRow = { customer_id: customerId, customer_name: customerName };
            this.showPointsDialog = true;
        }
    }
};
</script>
