<template>
    <div>
        <!-- <header class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Resúmenes</span></li>
            </ol>
            <div class="right-wrapper pull-right">
                <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nuevo</button>
            </div>
        </header> -->
         <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                <div class="col-sm-6">
                    <h6><span>Resumen</span></h6>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><span class="text-muted">Resumen de Boletas</span></li>
                    </ol>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-start justify-content-end">
                    <!-- Contact Button Start -->
                    <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" @click.prevent="clickCreate()">
                    <i class="icofont-plus-circle"></i>
                    <span>Nuevo</span>
                    </button>
                    <!-- Contact Button End -->
                </div>
              
                </div>
            </div>
    </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Listado de resúmenes</h6>
            </div>

             <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">Fecha Emisión</th>
                        <th class="text-center">Fecha Referencia</th>
                        <th>Identificador</th>
                        <th>Estado</th>
                        <th>Ticket</th>
                        <th class="text-center">Descargas</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }" >
                        <td>{{ index  }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td class="text-center">{{ row.date_of_reference }}</td>
                        <td>{{ row.identifier }}</td>
                        <td>{{ row.state_type_description }}</td>
                        <td>{{ row.ticket }}</td>
                        <td class="text-center">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickDownload(row.download_xml)"
                                    v-if="row.has_xml">XML</button> 
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickDownload(row.download_cdr)"
                                    v-if="row.has_cdr">CDR</button>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-warning"
                                    @click.prevent="clickTicket(row.id)"
                                    dusk="consult-ticket"
                                    v-if="row.btn_ticket">Consultar</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                    @click.prevent="clickDelete(row.id)"
                                    v-if="row.btn_ticket">Eliminar</button>
                        </td>
                    </tr>
                </data-table>
            </div>
            
            <summary-form :showDialog.sync="showDialog"
                        :external="false"></summary-form>
        </div>
    </div>

</template>

<script>

    import SummaryForm from './form.vue'
    import DataTable from '../../components/DataTable.vue'
    import {deletable} from '../../mixins/deletable'

    export default {
        mixins: [deletable],
        components: {DataTable, SummaryForm},
        data () {
            return {
                resource: 'summaries',
                showDialog: false,
                records: [],
            }
        },
        created() {

        },
        methods: { 
            clickCreate() {
                this.showDialog = true
            },
            clickTicket(id) {
                this.$http.get(`/${this.resource}/status/${id}`)
                    .then(response => {
                        if (response.data.success) {
                            this.$eventHub.$emit('reloadData') 
                            this.$toast.success(response.data.message)
                        } else {
                            this.$toast.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message)
                    })
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
            clickDownload(download) {
                window.open(download, '_blank');
            },
        }
    }
</script>
