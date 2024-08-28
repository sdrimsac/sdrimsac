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
                        <th class="text-center">TIPO CREDITO</th>
                        <th class="text-center">USUARIO</th>
                        <th class="text-center">TIPO</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="text-end">DNI</th>
                        <th class="text-end">DIAS DE ATRASO</th>
                        <th class="text-end">COBRO POR MORA</th>
                        <th class="text-end">TOTAL MORA</th>
                        <th class="text-end">COBRO POR CUOTA</th>
                        <th class="text-end">TOTAL A COBRAR</th>
                    </tr>

                    <tr></tr>
                    <template slot-scope="{index,row}">
                    <tr>
                        <td>{{ index }}</td>
                        <td class="text-center">
                            {{ row.is_cash ? "EFECTIVO" : "HOGAR" }}
                        </td>
                        <td class="text-center">{{ row.user_name }}</td>
                        <td class="text-center">{{ row.type_payment }}</td>
                        <td class="text-center">{{ row.customer.name }}</td>
                        <td class="text-center">{{ row.customer.number }}</td>
                        <!-- <td class="text-center">{{ row.differenc_days }}</td>
                        <td class="text-end">{{ row.penalty }}</td>
                        <td class="text-end">{{ row.quote_payment }}</td>
                        <td class="text-end">{{ row.amount_due }}</td> -->
                        <td class="text-end">
                            {{row.payments[0].diffence_days}}
                        </td>
                        <td class="text-end">
                            {{row.penalty_amount_by_day}}
                        </td>
                            <td class="text-end">
                            {{row.payments[0].total_penalty}}
                        </td>
                        <td class="text-end">
                            {{row.payments[0].payment}}
                        </td>
                        <td class="text-end">
                            {{row.payments[0].total}}
                        </td>
                    </tr>
                    <tr v-for="(payment, paymentIndex) in row.payments.slice(1)" :key="paymentIndex">
                        <td class="text-end"></td>
                        <td class="text-end"></td>
                        <td class="text-end"></td>
                        <td class="text-end"></td>
                        <td class="text-end"></td>
                        <td class="text-end"></td>
                        <td class="text-end">{{ payment.diffence_days }}</td>
                        <td class="text-end">{{ row.penalty_amount_by_day }}</td>
                        <td class="text-end">{{ payment.total_penalty }}</td>
                        <td class="text-end">{{ payment.payment }}</td>
                        <td class="text-end">{{ payment.total }}</td>
                    </tr>
                    </template>
                </data-table>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../components/DataTableReportsCreditsDaily.vue";

export default {
    components: { DataTable },
    data() {
        return {
            resource: "reports/credits/daily_credit",
            form: {},
            date: moment().format("YYYY-MM-DD")
        };
    },
    async created() {},
    methods: {
        updateDate(date) {
            this.date = date;
        }
    }
};
</script>
