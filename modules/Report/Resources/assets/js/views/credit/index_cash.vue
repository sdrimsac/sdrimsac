<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Crédito hogar/efectivo</h6>
        </div>
        <div class="card mb-0">
            <div class="card-body" v-show="type == 'is_cash'">
                <data-table :resource="resource"
                :type.sync="type"
                >
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
                        <td class="text-center">{{ row.count }}</td>
                        <td class="text-center">{{ row.total }}</td>
                        <td class="text-center">{{ row.tasa }}</td>
                        <td class="text-center">{{ row.type_payment }}</td>
                        <td class="text-center">{{ Number(row.gain).toFixed(2) }}</td>
                        <td class="text-end">{{ row.total_penalties }}</td>
                        <td class="text-end">{{ Number(row.total_gain).toFixed(2) }}</td>
                    </tr>
                </data-table>
            </div>
            <div class="card-body" v-show="type !== 'is_cash'" >
                    <data-table-product resource="reports/credits/cash_credit_product"
                :type.sync="type"
                >
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">CANT.</th>
                        <th class="text-center">CREDI HOGAR</th>
                        <th class="text-center">PC</th>
                        <th class="text-center">PRODUCTO</th>
                        <th class="text-center">%</th>
                        <th class="text-center">TIPO</th>
                        <th class="text-center">GANANCIA %</th>
                        <th class="text-end">MORA</th>
                        <th class="text-end">UTILIDAD</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.count }}</td>
                        <td class="text-center">{{ row.total }}</td>
                        <td class="text-center">{{ row.purchase_unit_price }}</td>
                        <td class="text-center">{{ row.product }}</td>
                        <td class="text-center">{{ row.tasa }}</td>
                        <td class="text-center">{{ row.type_payment }}</td>
                        <td class="text-center">{{ Number(row.gain).toFixed(2) }}</td>
                        <td class="text-end">{{ 
                            Number(row.total_penalties).toFixed(2)
                             }}</td>
                        <td class="text-end">{{ Number(row.total_gain).toFixed(2) }}</td>
                    </tr>
                </data-table-product>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../components/DataTableReportsCreditsTypes.vue";
import DataTableProduct from "../../components/DataTableReportsCreditsTypesProduct.vue";

export default {
    components: { DataTable,DataTableProduct },
    data() {
        return {
            resource: "reports/credits/cash_credit",
            form: {},
            type: "is_cash"
        };
    },
    async created() {},
    methods: {}
};
</script>
