<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de métodos de pago</h6>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th class="">#</th>
                        <th class="">Usuario</th>
                        <th class="">Fecha</th>
                        <th class="">Hora</th>
                        <th class="">Cliente</th>
                        <th class="">Documento</th>
                        <th class="">Método de pago</th>
                        <th class="">N° Operación</th>
                        <th class="">Monto</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>
                            {{ row.user }}
                        </td>
                        <td>
                            {{ row.date }}
                        </td>
                        <td>
                            {{ row.time }}
                        </td>
                        <td>
                            {{ row.customer_name }}
                        </td>
                        <td>
                            {{ row.customer_document }}
                        </td>
                        <td>{{ row.method }}</td>
                        <td>
                            {{ row.operation_number }}
                        </td>
                        <td>
                            {{ row.amount }}
                        </td>
                    </tr>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../components/DataTableMethods.vue";

export default {
    components: { DataTable },
    data() {
        return {
            resource: "reports/methods",
            form: {}
        };
    },
    async created() {},
    methods: {}
};
</script>
