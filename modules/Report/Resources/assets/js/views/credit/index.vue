<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary" style="padding: 8px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-credit-card fa-2x text-white" aria-hidden="true"></i>
                <h5 class="my-0 text-white ms-3">Listado de Créditos con Nota de venta</h5>
            </div>
            <!-- <h5 class="my-0 text-white">Consulta de Nota de venta</h5> -->
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <data-table :isFromAdmin="true" :resource="resource">
                    <tr slot="heading" style="background-color: #073f68; color: #ffffff;">
                        <th class="text-white">#</th>
                        <th class="text-center text-white">Comprobante N/V</th>
                        <!-- <th class="text-center text-white">Fecha de emisión</th> -->
                        <th class="text-left text-white">Clientes</th>
                        <!-- <th class="text-center text-white">Nombres</th> -->
                        <th class="text-center text-white">
                            N° Cuotas
                            <br>
                             Vencidas</th>
                        <th class="text-end text-white">Fecha de cobro</th>
                        <th class="text-end text-white">Monto</th>
                        <th class="text-end text-white">Días de atraso</th>
                        <th class="text-end text-white">N° cuotas</th>
                        <th class="text-end text-white">S/ Cuota</th>
                        <th class="text-end text-white">Total</th>
                        <th class="text-center text-white">
                            Crédito
                            <br>
                            Otorgado
                        </th>
                        <th class="text-end text-white">Ganancia</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }" >
                        <td>{{ index }}</td>

                        <td class="text-center">
                            <span class="fw-bold" style="font-size:1.1rem">{{ row.number }}</span>
                            <br>
                            {{ row.date_of_issue }}

                        </td>
                        <!-- <td class="text-center"></td> -->
                        <td class="text-left">
                            {{ row.customer.name }}
                            <br>
                            {{ row.customer.number }}</td>
                        <!-- <td class="text-center"></td> -->
                        <td class="text-center">
                            <span :style="{ fontWeight: '700', fontSize: '1.1rem', color: row.dues > 0 ? '#8B0000' : 'inherit' }">
                                {{ row.dues }}
                            </span>
                        </td>
                        <td class="text-end">{{ row.date_of_due }}</td>
                        <td class="text-end">{{ row.amount_due }}</td>
                        <td class="text-end">{{ row.differenc_days }}</td>
                        <td class="text-end">
                            {{ row.total_number_payments }}
                        </td>
                        <td class="text-end">
                            {{ row.quote_payment }}
                        </td>
                        <td class="text-end">
                            {{ Number(row.total_quotes_payment).toFixed(2) }}
                        </td>
                        <td class="text-end">
                            {{ Number(row.total_net).toFixed(2) }}
                        </td>
                        <td class="text-end">
                            {{ Number(row.int).toFixed(2) }}
                        </td>
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
    async created() { },
    methods: {}
};
</script>
