<template>
    <section class="card">
        <div class="card-header bg-primary d-flex align-items-center"
            style="padding: 10px; background: linear-gradient(90deg,#0b5a8a,#032a4a); ">
            <span style="color: white; font-weight: bold;">Productos con Stock Mínimo</span>
        </div>
        <div class="card-body">
            <simple-data-table :resource="resource">
                <tr slot="heading" style="background-color: #073f68;">
                    <th style="color: white;">#</th>
                    <th style="color: white;">Producto</th>
                    <th class="text-center" style="color: white;">Stock</th>
                    <th style="color: white;">Estado</th>
                    <th style="color: white;">Almacén</th>
                    <th class="text-center" style="color: white;">Aprovisionar</th>
                </tr>
                <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                    <td>{{ index }}</td>
                    <td>{{ row.product }}</td>
                    <td class="text-center">{{ row.stock }}</td>
                    <td>
                        <span class="badge bg-danger text-white" v-if="row.state == '01'">Agotado</span>
                        <span class="badge bg-warning text-white" v-if="row.state == '02'">Pocas Unidades</span>
                    </td>
                    <td>{{ row.warehouse.replace('Almacén - ', '') }} </td>
                    <td class="text-center">
                        <button type="button" style="min-width: 41px"
                            class="btn waves-effect waves-light btn-sm btn-primary m-1__2"
                            @click.prevent="clickProvision()"><i class="fas fa-shopping-cart"></i></button>
                    </td>

                </tr>
            </simple-data-table>
        </div>
    </section>
</template>


<script>

import SimpleDataTable from '../../components/SimpleDataTable.vue'

export default {
    components: { SimpleDataTable },

    data() {
        return {
            resource: 'dashboard/stock-by-product',
            records: []
        }
    },
    created() {
    },
    methods: {
        clickProvision() {
            window.open('/purchases/create')
        }
    }
}
</script>