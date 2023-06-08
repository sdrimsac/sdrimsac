<template>
    <div>
    <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                <div class="col-sm-6">
                    <h6><span>{{ title }}</span></h6>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><span class="text-muted">{{ title }}</span></li>
                    </ol>
                </div>
                 
                </div>
            </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">   
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">{{ title }}</h6>
            </div>
            <div class="card-body">

                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th>Producto</th>
                        <th >Categoría</th>
                        <th class="text-center">Unidad</th>
                        <th class="text-center">Unidades físicas vendidas</th>
                        <th class="text-center">Costo unitario</th>
                        <th class="text-center">Valor de ventas</th>
                        <th class="text-center">Costo de producto</th>
                        <th class="text-center">Unidad valorizada</th>
                    <tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.item_description }}</td>
                        <td>{{ row.category_description }}</td>
                        <td  class="text-center">{{ row.unit_type_id }}</td>
                        <td  class="text-center">{{ row.quantity_sale }}</td>
                        <td class="text-center">{{ row.purchase_unit_price }}</td>
                        <td class="text-center">{{ row.total_sales }}</td>
                        <td class="text-center">{{ row.item_cost }}</td>
                        <td class="text-center">{{ row.valued_unit }}</td>
                    </tr>
                </data-table>

            </div>


        </div>
    </div>    
</div>
</template>

<script>


    import DataTable from '../../components/DataTableValuedKardex.vue'

    export default {
          components: {DataTable},
        data() {
            return {
                title: null,
                resource: 'reports/valued-kardex',
            }
        },
        created() {
            this.title = 'Kardex valorizado'
        },
        methods: {
        }
    }
</script>
