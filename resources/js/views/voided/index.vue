<template>
    <div>
                <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                <div class="col-sm-6">
                    <h6><span>anulaciones</span></h6>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><span class="text-muted">anulaciones de Comprobantes</span></li>
                    </ol>
                </div>
                 
                </div>
            </div>
    </div>
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Listado de anulaciones</h6>
            </div>
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">F.Emisión</th>
                        <th class="text-center">F.E.Comprobante</th>
                        <th>Identificador</th>
                        <th>Ticket</th>
                        <th>Estado</th>
                        <th class="text-center">Descargas</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }" :class="{'text-danger': (row.state_type_id === '05'), 'text-warning': (row.state_type_id === '03')}">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td class="text-center">{{ row.date_of_reference }}</td>
                        <td>{{ row.identifier }}</td>
                        <td>{{ row.ticket }}</td>
                        <td>{{ row.state_type_description }}</td>
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
                                    @click.prevent="clickTicket(row.type, row.id)"
                                    dusk="consult-voided"
                                    v-if="row.btn_ticket">Consultar</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                    @click.prevent="clickDelete(row.type, row.id)"
                                    v-if="row.btn_ticket">Eliminar</button>
                        </td>
                    </tr>
                </data-table>
            </div>
        </div>
    </div>

</template>

<script>

    import DataTable from '../../components/DataTable.vue'
    import {deletable} from '../../mixins/deletable'

    export default {
        mixins: [deletable],
        components: {DataTable},
        data () {
            return {
                resource: 'voided',
                showDialog: false,
                records: [],
                loading_submit_voided: false,
            }
        },
        created() {
        },
        methods: {
            clickTicket(type, id) {
                this.$http.get(`/${type}/status/${id}`)
                    .then(response => {
                        if (response.data.success) {
                            this.$toast.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                        } else {
                            this.$toast.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message)
                    })
            },
            clickDelete(type, id) {
                this.destroy(`/${type}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
            clickDownload(download) {
                window.open(download, '_blank');
            },
            consultVoided()
            {
                this.loading_submit_voided = true
                this.$http.get(`/voided/status_masive`)
                    .then(response => {
                        if (response.data.success) {
                            this.$toast.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                        } else {
                            this.$toast.error('Sucedio un error')
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit_voided = false
                    })
            }
        }
    }
</script>
