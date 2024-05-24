<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Crédito hogar/efectivo</h6>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">CANT.</th>
                        <th class="text-center">CREDI EFECTIVO</th>
                        <th class="text-center">%</th>
                        <th class="text-center">TIPO</th>
                        <th class="text-center">GANANCIA %</th>
                        <th class="text-end">MORA</th>
                        <th class="text-end">UTILIDAD</th>
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
                    </tr>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../components/DataTableReportsCreditsTypes.vue";

export default {
    components: { DataTable },
    data() {
        return {
            resource: "reports/credits/cash_credit",
            form: {}
        };
    },
    async created() {},
    methods: {}
};
</script>
