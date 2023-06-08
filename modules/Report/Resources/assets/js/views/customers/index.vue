<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Consulta de documentos por cliente</h6>
        </div>
        <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th class="">#</th>
                            <th class="">Fecha Emisión</th>
                            <th class="">Fecha Pago</th>
                            <th class="">Tipo Documento</th>
                            <th class="">Serie</th>
                            <th class="">Número</th>
                            <th class="">Monto</th>
                            <th class="">Pago</th>
                        <tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td> 
                            <td>{{row.date_of_issue}}</td>
                              <td>{{row.date_payment}}</td>
                            <td>{{row.document_type_description}}</td>
                            <td>{{row.series}}</td>
                            <td>{{row.alone_number}}</td>
                            <td>{{ (row.document_type_id == '07') ? ( (row.total == 0) ? '0.00': '-'+row.total) : ((row.document_type_id!='07' && (row.state_type_id =='11'||row.state_type_id =='09')) ? '0.00':row.total) }}</td> 
                            <td>
                                <span class="badge bg-warning text-white"  v-if="row.pendient=='PENDIENTE'">Pendiente</span>
                                <span class="badge bg-success text-white"  v-if="row.pendient=='PAGADO'">Pagado</span>

                            </td>
                        </tr>
                        
                    </data-table>
                     
                    
                </div> 
        </div>
 
    </div>
</template>

<script>
 
    import DataTable from '../../components/DataTableCustomers.vue'

    export default { 
        components: {DataTable},
        data() {
            return {
                resource: 'reports/customers',                 
                form: {}, 

            }
        },
        async created() { 
        },
        methods: { 
             
            
        }
    }
</script>