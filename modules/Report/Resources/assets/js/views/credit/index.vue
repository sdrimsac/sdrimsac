<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de Nota de venta</h6>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">N/V</th>
                        <th class="text-center">Fecha de emisión</th>
                        <th class="text-center">DNI</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">N° Cuotas Vencidas</th>
                        <th class="text-end">Fecha de cobro</th>
                        <th class="text-end">Monto</th>
                        <th class="text-end">Días de atraso</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>

                        <td class="text-center">{{ row.number }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td class="text-center">{{ row.customer.number }}</td>
                        <td class="text-center">{{ row.customer.name }}</td>
                        <td class="text-center">{{ row.dues }}</td>
                        <td class="text-end">{{ row.date_of_due }}</td>
                        <td class="text-end">{{ row.amount_due }}</td>
                        <td class="text-end">{{ row.differenc_days }}</td>
                    </tr>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../components/DataTableReportsCredits.vue";

export default {
    components: { DataTable },
    data() {
        return {
            resource: "reports/credits",
            form: {}
        };
    },
    async created() {},
    methods: {}
};
</script>
