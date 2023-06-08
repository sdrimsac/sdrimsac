<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de Margen Utilidad</h6>
        </div>
        <div class="card mb-0">
                <div class="card-body">
                    <data-table :applyCustomer="true" :resource="resource">
                        <tr slot="heading">
                            <th class="">#</th>
                            <th class="">Usuario/Vendedor</th>
                            <th class="">Tipo Documento</th>
                             <th class="">Fecha emisión</th>
                            <th>Cliente</th>
                            <th class="">Producto</th>
                             <th class="">Utilidad</th>
                        <tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{row.user_name}}</td>
                            <td>{{row.document}}<br>
                            <small v-text="row.number_full" class='badge bg-secondary text-white'></small> 
                            </td>
                             
                            <td>{{row.date_of_issue}}</td>
                            <td>{{row.customer}}</td>
                            <td>
                                 <el-popover
                                placement="right"
                                width="580"
                                trigger="click">
                                <el-table :data="row.item">
                                    <el-table-column width="60" property="item_id" label="#"></el-table-column>
                                    <el-table-column width="150" property="description" label="Nombre"></el-table-column>
                                    <el-table-column width="90" property="quantity" label="Cantidad"></el-table-column>
                                    <el-table-column width="80" property="purchase_unit_price" label="P. Compra"></el-table-column>
                                    <el-table-column width="80" property="sale_unit_price" label="P. Venta"></el-table-column>
                                     <el-table-column width="80" property="margen" label="Utilidad"></el-table-column>
                                </el-table>
                                <el-button slot="reference"> <i class="fa fa-eye"></i></el-button>
                            </el-popover>
                            </td>
                            <td>{{row.total_margen}}</td>
                        </tr>

                    </data-table>


                </div>
        </div>

    </div>
</template>

<script>

    import DataTable from '../../components/DataTableReportsUtil.vue'

    export default {
        components: {DataTable},
        data() {
            return {
                resource: 'reports/margin',
                form: {},

            }
        },
        async created() {
        },
        methods: {


        }
    }
</script>
