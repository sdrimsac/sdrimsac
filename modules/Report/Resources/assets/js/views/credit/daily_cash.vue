<!-- Listado de Créditos hogar/efectivo -->
<template>
    <div class="card ">
        <div class="card-header bg-primary">
            
            <h5 class="my-0 text-white">Créditos Hogar - Efectivo</h5>
        </div>
        <div class="card mt-1">
            <div class="card-body">
                <data-table :resource="resource" ref="dtable">
                    <tr slot="heading" style="background-color:#073f68;color:#fff;">
                        <th class="text-white" style="width:3%;">#</th>
                        <th class="text-center text-white" style="width:8%;">Tipo Crédito</th>
                        <th class="text-center text-white" style="width:10%;">Usuario</th>
                        <th class="text-center text-white" style="width:10%;">
                            Tipo de
                            <br>
                            Crédito
                        </th>
                        <th class="text-left text-white" style="width:18%;">Cliente</th>
                        <!-- <th class="text-center text-white" style="width:8%;">DNI</th> -->
                        <th class="text-center text-white" style="width:5%;">N° Cuota</th>
                        <th class="text-center text-white" style="width:6%;">
                            Días de
                            <br>
                            Atraso
                        </th>
                        <th class="text-end text-white" style="width:7%;">
                            Cobro x
                            <br>
                            Mora
                        </th>
                        <th class="text-center text-white" style="width:7%;">
                            Total
                            <br>
                            Mora
                        </th>
                        <th class="text-end text-white" style="width:7%;">
                            Cobro x
                            <br>
                            Cuota
                        </th>
                        <th class="text-end text-white" style="width:11%;">
                            Total A
                            <br>
                            Cobrar
                        </th>
                    </tr>

                    <tr></tr>
                    <template slot-scope="{ index, row }">
                        <tr @click="visiblePayments(index)" role="button"
                            :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                            <td>
                                {{ index }}
                            </td>
                            <td class="text-center">
                                <button type="button"
                                    :class="['btn', row.is_cash ? 'btn-success' : 'btn-warning', 'w-100']"
                                    style="font-weight:bold;">
                                    {{ row.is_cash ? 'EFECTIVO' : 'HOGAR' }}
                                </button>
                            </td>
                            <td class="text-left">{{ row.user_name }}</td>
                            <td class="text-center">
                                <span
                                    style="font-weight:bold; font-size:1.2em; text-transform:uppercase; display:inline-block;">
                                    {{ (row.type_payment || '').toString().toUpperCase() }}
                                </span>
                            </td>
                            <td class="text-left">
                                <span style="font-size:1.2em; font-weight:bold; display:inline-block;">
                                    {{ row.customer.number }}
                                </span>
                                <br>
                                {{ row.customer.name }}
                            </td>
                            <!-- <td class="text-center">
                               
                            </td> -->
                            <td></td>
                            <!-- <td class="text-center">{{ row.differenc_days }}</td>
                        <td class="text-end">{{ row.penalty }}</td>
                        <td class="text-end">{{ row.quote_payment }}</td>
                        <td class="text-end">{{ row.amount_due }}</td> -->
                            <td class="text-end"></td>
                            <td class="text-end"></td>
                            <td class="text-end" style="font-weight:bold;color:#000;">
                                {{
                                    row.payments
                                        .reduce(
                                            (acc, payment) =>
                                                acc +
                                                Number(payment.total_penalty),
                                            0
                                        )
                                        .toFixed(2)
                                }}
                            </td>
                            <td class="text-end" style="font-weight:bold;color:#000;">
                                {{
                                    row.payments
                                        .reduce(
                                            (acc, payment) =>
                                                acc + Number(payment.payment),
                                            0
                                        )
                                        .toFixed(2)
                                }}
                            </td>
                            <td class="text-end" style="font-weight:bold;color:#000;">
                                <span style="font-weight: bold; font-size: 1.2em;">
                                    {{ row.payments.reduce((acc, payment) => acc + Number(payment.total), 0).toFixed(2) }}
                                </span>
                            </td>
                        </tr>
                        <tr v-show="row.visible" v-for="(payment, paymentIndex) in row.payments"
                            :key="`${row.customer.name}-${paymentIndex}`"
                            :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">

                            <!-- <td class="text-end"></td>
                            <td class="text-end"></td> -->
                            <td class="text-end"></td>
                            <td class="text-end"></td>
                            <td class="text-end"></td>
                            <td class="text-end"></td>
                            <td class="text-end"></td>
                            <td class="text-center">
                                {{ payment.installment_number }}
                            </td>
                            <td class="text-center">
                                {{ payment.diffence_days }}
                            </td>
                            <td class="text-end">
                                {{ row.penalty_amount_by_day }}
                            </td>
                            <td class="text-end">
                                {{ Number(payment.total_penalty).toFixed(2) }}
                            </td>
                            <td class="text-end">
                                {{ Number(payment.payment).toFixed(2) }}
                            </td>
                            <td class="text-end">
                                {{ Number(payment.total).toFixed(2) }}
                            </td>


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
    async created() { },
    methods: {
        visiblePayments(index) {
            this.$refs.dtable.updateRowVisible(index);
        },
        updateDate(date) {
            this.date = date;
        }
    }
};
</script>
