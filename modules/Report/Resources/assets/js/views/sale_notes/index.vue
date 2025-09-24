
<!-- Modulo de Consulta de Notas de Venta -->
<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h4 class="my-0 text-white">
                <i class="fas fa-file-alt"></i>
                Consulta de Nota de venta ffdfdf</h4>
        </div>
        <div class="card mb-0">
                <div class="card-body">
                    <data-table :resource="resource" :applyCustomer="true">
                        <tr slot="heading">
                            <th>#</th>
                            <th class="text-center">Fecha Emisión</th>
                            <th class="">Usuario/Vendedor</th>
                            <th>Cliente</th>
                            <th>Nota de Venta</th>
                            <th>Estado</th>
                            <th class="text-center">Moneda</th>
                            <th class="text-center">Comprobantes</th>
                            <th>Cotización</th>
                            <th>Caso</th>
                            <th class="text-end" >T.Exportación</th>
                            <th class="text-end" >T.Inafecta</th>
                            <th class="text-end" >T.Exonerado</th>

                            <th class="text-end">T.Gravado</th>
                            <th class="text-end">T.Igv</th>
                            <th class="text-end">Total</th>
                        </tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>  
                            <td>{{row.date_of_issue}}</td>
                            <td>{{row.user_name}}</td>
                            <td>{{row.customer_name}}</td>
                            <td>{{row.identifier}}</td>
                            <td>{{row.state_type_description}}</td>
                            <td>{{row.currency_type_id}}</td>
                            <td>
                                <template v-for="(doc,i) in row.documents">                                
                                    <label class="d-block" :key="i">{{doc.number_full}}</label>
                                </template>
                            </td>
                            <td>{{row.quotation_number_full}}</td>
                            <td>{{row.sale_opportunity_number_full}}</td>
                            <td >{{ (row.state_type_id == '11') ? "0.00" : row.total_exportation }}</td>
                            <td >{{ (row.state_type_id == '11') ? "0.00" : row.total_unaffected }}</td>
                            <td >{{ (row.state_type_id == '11') ? "0.00" : row.total_exonerated }}</td>

                            <td>{{ (row.state_type_id == '11') ? "0.00" : row.total_taxed}}</td>
                            <td>{{ (row.state_type_id == '11') ? "0.00" : row.total_igv}}</td>
                            <td>{{ (row.state_type_id == '11') ? "0.00" : row.total}}</td>
                            
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
                resource: 'reports/sale-notes',                 
                form: {}, 

            }
        },
        async created() { 
        },
        methods: { 
             
            
        }
    }
</script>
<style scoped>
/* Encabezado de la tabla */
.data-table thead th,
table thead th {
    background-color: #15344a !important;
    color: #fff !important;
    font-weight: bold;
    text-align: center;
}

/* Filas alternas (zebra striping) */
.data-table tbody tr:nth-child(even),
table tbody tr:nth-child(even) {
    background-color: #f6f6f6;
}
.data-table tbody tr:nth-child(odd),
table tbody tr:nth-child(odd) {
    background-color: #e3ded3;
}

/* Bordes sutiles */
.data-table th, .data-table td,
table th, table td {
    border: 1px solid #e0e0e0;
    vertical-align: middle;
}

/* Ajuste de padding y alineación */
.data-table th, .data-table td,
table th, table td {
    padding: 8px 10px;
}

/* Alineación de columnas específicas */
.text-center {
    text-align: center !important;
}
.text-end {
    text-align: right !important;
}
</style>