<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Comisiones vendedores - ventas</h6>
        </div>
        <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <!-- <th class="text-center">Código vendedor</th> -->
                            <th>Vendedor</th>
                            <th class="text-center">Cantidad transacciones</th>
                            <th class="text-center">Ventas acumuladas</th>
                            <th class="text-center">Total comisiones</th>
                            <th class="text-center">Total comisiones NV</th>
                            <th class="text-center">Total comisiones CPE</th>
                        <tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>  
                            <!-- <td>{{row.user_name}}</td> -->
                            <td>{{row.user_name}}</td>
                            <td class="text-center">{{row.total_transactions}}</td>
                            <td class="text-center">{{row.acum_sales}}</td> 
                            <td class="text-center">{{row.total_commision}}</td> 
                            <td class="text-center">{{row.total_commision_sale_note}}</td> 
                            <td class="text-center">{{row.total_commision_document}}</td> 
                        </tr>
                        
                    </data-table>
                     
                    
                </div> 
        </div>
 
    </div>
</template>

<script>
 
    import DataTable from '../../components/DataTableReports.vue'

    export default { 
        components: {DataTable},
        data() {
            return {
                resource: 'reports/commissions',                 
                form: {}, 

            }
        },
        async created() { 
        },
        methods: { 
             
            
        }
    }
</script>