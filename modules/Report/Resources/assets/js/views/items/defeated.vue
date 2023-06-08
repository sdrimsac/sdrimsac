<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de productos vencidos</h6>
        </div>
        <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th class="">#</th>
                            <th class="">Fecha Vence</th>
                            <th class="">Producto</th>
                            <th class="">Codigo Interno</th>
                            <th class="">Unidad Medida</th>
                            <th class="">Precio Compra</th>
                            <th class="">Precio Venta</th>
                            <th class="">Stock</th>
                            
                        <tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td> 
                            <td>{{row.date_of_due}}</td>
                            <td>{{row.description}}</td>
                            <td>{{row.internal_id}}</td>
                            <td>{{row.unit_type_id}}</td>
                            <td>{{row.purchase_unit_price}}</td>
                            <td>{{row.sale_unit_price}}</td>
                            <td>{{row.stock}}</td>
                         </tr>
                        
                    </data-table>
                     
                    
                </div> 
        </div>
 
    </div>
</template>

<script>
 
    import DataTable from '../../components/DataTableItems2.vue'

    export default { 
        components: {DataTable},
        data() {
            return {
                resource: 'reports/defeated',                 
                form: {}, 

            }
        },
        async created() { 
        },
        methods: { 
             
            
        }
    }
</script>