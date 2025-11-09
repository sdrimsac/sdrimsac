<template>
    <div class="card ">
        <div class="card-header bg-primary">
            <h5 class="my-0 text-white">Ganancias Crédito Hogar - Efectivo</h5>
        </div>
        <div class="card mb-0">
            <div class="card-body" v-show="type == 'is_cash'">
                <data-table :resource="resource"
                :type.sync="type"
                >
                    <tr slot="heading" style="background-color: #073f68; color: #fff;">
                        <th class="text-white">#</th>
                        <th class="text-center text-white text-capitalize">Cant.</th>
                        <th class="text-center text-white text-capitalize">Credi Efectivo</th>
                        <th class="text-center text-white">%</th>
                        <th class="text-center text-white text-capitalize">Tipo</th>
                        <th class="text-center text-white text-capitalize">Ganancia %</th>
                        <th class="text-end text-white text-capitalize">Mora</th>
                        <th class="text-end text-white text-capitalize">Utilidad</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.count }}</td>
                        <td class="text-center">{{ Number(row.total).toFixed(2) }}</td>
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
                    <tr slot="heading" style="background-color: #073f68; color: #fff;">
                        <th class="text-white">#</th>
                        <th class="text-center text-white text-capitalize">Cant.</th>
                        <th class="text-center text-white text-capitalize">Credi Hogar</th>
                        <th class="text-center text-white text-capitalize">Compra</th>
                        <th class="text-left text-white text-capitalize">Producto</th>
                        <th class="text-center text-white text-capitalize">%</th>
                        <th class="text-center text-white text-capitalize">Tipo</th>
                        <th class="text-center text-white text-capitalize">Ganancia %</th>
                        <th class="text-end text-white text-capitalize">Mora</th>
                        <th class="text-end text-white text-capitalize">Utilidad</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.count }}</td>
                        <td class="text-right">{{ Number(row.total).toFixed(2) }}</td>
                        <td class="text-right">{{ Number(row.purchase_unit_price).toFixed(2) }}</td>
                        <td class="text-left">{{ row.product }}</td>
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
