<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consolidado de Productos por cliente/vendedor - ventas</h6>
        </div>
        <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th class="">#</th>
                            <th  class="text-left">Producto</th>
                            <th  class="text-center">Cantidad</th>
                            <th  class="text-center">Precio Unit.</th>
                            <th  class="text-center">Importe</th>
                        <tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td> 
                            <td  class="text-left">{{row.item_description}}</td>
                            <td  class="text-center">{{row.item_quantity}}</td>
                             <td  class="text-center">{{row.unit_price}}</td>
                            <td  class="text-center">{{row.total}}</td>
                        </tr>
                    </data-table>
                    
                </div> 
        </div>
 
    </div>
</template>

<script>
 
    import DataTable from '../../components/DataTableOrderNotesConsolidated.vue'

    export default { 
        components: {DataTable},
        data() {
            return {
                resource: 'reports/sales-consolidated',                 
                form: {}, 

            }
        },
        async created() { 
        },
        methods: { 
             
            
        }
    }
</script>