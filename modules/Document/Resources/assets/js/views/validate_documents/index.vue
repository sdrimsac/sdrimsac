<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Validador de documento</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active">
                          <el-tooltip class="item" effect="dark" content="Los comprobantes se deben haber generado en entorno producción" placement="top-start">
                            <i class="fa fa-info-circle"></i>
                        </el-tooltip>    
                     </li>
                  </ol>
                </div>
                 
              </div>
            </div>
          </div>
         <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0" v-loading="loading_submit" :element-loading-text="loading_text" > 
            <div class="card-body ">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th>Entorno</th>
                        <th>Comprobante</th>
                        <th class="text-center">F. Emisión</th>
                        <th>Cliente</th>
                         <th >Estado sistema</th>
                     <tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.soap_type_description }}</td>
                        <td>{{ row.number }}<br/>
                            <small v-text="row.document_type_description"></small><br/>
                            <small v-if="row.affected_document" v-text="row.affected_document"></small>                            
                        </td>  
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td>{{ row.customer_name }}<br/><small v-text="row.customer_number"></small></td>
                        
                        
                       
                        
                        <td>
                            <span class="badge bg-secondary text-white" :class="{'bg-danger': (row.state_type_description == 'ANULADO'), 
                            'bg-warning': (row.state_type_description == 'POR ANULAR'), 
                            'bg-secondary': (row.state_type_description == 'REGISTRADO'), 
                            'bg-primary': (row.state_type_description == 'ENVIADO'), 
                            'bg-success': (row.state_type_description == 'ACEPTADO'), 
                            'bg-secondary': (row.state_type_description == 'OBSERVADO'), 
                            'bg-dark': (row.state_type_description == 'RECHAZADO'),
                            'bg-primary': (row.state_type_description == 'NO EXISTE')}">{{row.state_type_description}}</span>
                        </td>
                        <!-- <td >{{ row.state_type_sunat_description }}</td> -->
                    </tr>
                </data-table>
            </div>
 
        </div>
        </div>
    </div>
</template>

<script>
 
    import DataTable from '../../../../../../../resources/js/components/DataTableValidateDocuments.vue'

    export default {
        components: {DataTable},
        data() {
            return {
                showDialogVoided: false,
                showImportDialog: false,
                resource: 'reports/validate-documents',
                recordId: null,
                showDialogOptions: false,
                showDialogPayments: false, 
                loading_submit: false,
                loading_text: 'Validando documentos electrónicos...',
                  pickerOptionsDates: {
                    disabledDate: (time) => {
                        time = moment(time).format('YYYY-MM-DD')
                        return this.form.date_start > time
                    }
                },
                  pickerOptionsMonths: {
                    disabledDate: (time) => {
                        time = moment(time).format('YYYY-MM')
                        return this.form.month_start > time
                    }
                },
            }
        },
        created() {
            
            this.$eventHub.$on('valueLoading', (loading) => {
                this.loading_submit = loading
            })
        },
        methods: {  
        }
    }
</script>
