<template>
    <div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
            <h6><span>Solicitar cotización</span></h6>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><span class="text-muted">Solicitar cotización</span></li>
            </ol>
            </div>
            <div class="col-sm-6">
            <div class="bookmark">
            <ul>
                <li>
                    <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                        <a :href="`/${resource}/create`" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                            <i data-feather="plus-circle"></i>
                        </a>
                    </el-tooltip>
                </li>
                </ul>
            </div>
            <!-- Bookmark Ends-->
            </div>
        </div>
        </div>
    </div>
     <div class="container-fluid p-l-0 p-r-0">        
        <div class="card mb-0">
            <div class="data-table-visible-columns"> 
            </div>
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">Fecha Emisión</th>
                        <th>Estado</th>
                        <th>Documento</th> 
                        <th class="text-center">Descarga</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }" >
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td>{{row.state_type_description}}</td>
                        <td>{{ row.identifier }} 
                        </td>  
                        <td class="text-center"> 

                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickDownload(row.external_id)">PDF</button>
                        </td>
                        
                        <td class="text-end"> 
                                    
                            <button type="button" v-if="!row.has_purchase_orders" class="btn waves-effect waves-light btn-sm btn-success m-1__2"
                                    @click.prevent="clickGenerateOc(row.id)">Generar OC</button>

                            <button type="button" v-if="!row.has_purchase_orders" class="btn waves-effect waves-light btn-sm btn-custom m-1__2"
                                    @click.prevent="clickCreate(row.id)">Editar</button>

                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info m-1__2"
                                    @click.prevent="clickOptions(row.id)">Opciones</button>
                        </td>

                    </tr>
                </data-table>
            </div>
 

            <purchase-quotation-options :showDialog.sync="showDialogOptions"
                              :recordId="recordId"
                              :showGenerate="true"
                              :showClose="true"></purchase-quotation-options>
 
        </div>
        </div>
    </div>
</template>
<style scoped>
    .anulate_color{
        color:red;
    }
</style>
<script>
 
    import PurchaseQuotationOptions from './partials/options.vue'
    import DataTable from '../../../../../../../resources/js/components/DataTable.vue'
    // import {deletable} from '../../../mixins/deletable'

    export default { 
        // mixins: [deletable],
        components: {DataTable,PurchaseQuotationOptions},
        data() {
            return { 
                resource: 'purchase-quotations',
                recordId: null,
                showDialogOptions: false,
            }
        },
        created() {
        },
        methods: { 
            clickCreate(id = '') {
                location.href = `/${this.resource}/create/${id}`
            },
            clickGenerateOc(id = '') {
                location.href = `/purchase-orders/generate/${id}`
            },
            clickDownload(external_id) {
                window.open(`/${this.resource}/download/${external_id}`, '_blank');                
            },
            clickOptions(recordId = null) {
                this.recordId = recordId
                this.showDialogOptions = true
            },  
        }
    }
</script>
