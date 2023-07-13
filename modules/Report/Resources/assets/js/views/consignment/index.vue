<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de Consignamiento</h6>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">N°</th>
                        <th class="text-center">Fecha de emisión</th>
                        <th class="text-center">Fecha de liquidación</th>
                        <th class="text-left">Cliente/Vendedor</th>
                        <th class="text-center">Penalidad</th>
                        <th class="text-end">Productos</th>
                        <th class="text-end">Monto</th>
                        <th class="text-end">Estado</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>

                        <td class="text-center">{{ row.number }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td class="text-center">{{ row.date_of_end }}</td>
                        <td class="text-left">
                            {{ row.person.name }}
                            <br />
                            <small>{{ row.person.number }}</small>
                        </td>
                        <td class="text-center">{{ row.penalty }}</td>
                        <td class="text-end">{{ row.count_items }}</td>
                        <td class="text-end">{{ row.total.toFixed(2) }}</td>
                        <td class="text-end">{{ row.liquidated }}</td>
                    </tr>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../components/DataTableReportsConsignment.vue";

export default {
    components: { DataTable },
    data() {
        return {
            resource: "reports/consignment",
            form: {}
        };
    },
    async created() {},
    methods: {}
};
</script>
