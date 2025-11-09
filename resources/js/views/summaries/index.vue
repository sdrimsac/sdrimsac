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
           
        </div>
        <div class="card">
            <div class="card-header bg-primary d-flex align-items-center" style="padding: 10px;">
                <i class="fas fa-file-alt text-white" style="margin-right: 16px; font-size: 1.2em;"></i>
                <h5 class="my-0 text-white" style="font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-weight:600; font-size:1.05rem; letter-spacing:0.2px;">
                    Listado de Resúmenes de Boletas Electrónicas
                </h5>
            </div>
            <div class="data-table-visible-columns d-flex align-items-center">
                <button  class="btn_guardarsmall" type="primary"
                    @click.prevent="clickCreate()">
                    <i class="icofont-plus-circle"></i>
                    <span>Nuevo</span>
                </button>
            </div>

            <div class="card-body">
                <data-table :resource="resource" class="table-striped" ref="dataTable">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white" style="width: 10px;">#</th>
                        <th class="text-white text-center" style="width: 120px;">Fecha Emisión</th>
                        <th class="text-white text-center" style="width: 120px;">Fecha Referencia</th>
                        <th class="text-white text-center" style="width: 180px;">Identificador</th>
                        <th class="text-white text-center" style="width: 100px;">Estado</th>
                        <th class="text-white text-center" style="width: 100px;">Ticket</th>
                        <th class="text-white text-center" style="width: 120px;">Descargas</th>
                        <th class="text-white text-center" style="width: 120px;">Acciones</th>
                    </tr>
                    <tr slot-scope="{ index, row }">
                        <td class="text-center">{{ index }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td class="text-center">{{ row.date_of_reference }}</td>
                        <td class="text-center" style="font-weight: bold; font-size: 1.1em;">{{ row.identifier }}</td>
                        <td class="text-center">{{ row.state_type_description }}</td>
                        <td class="text-center">{{ row.ticket }}</td>
                        <td class="text-center">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary"
                                @click.prevent="clickDownload(row.download_xml)" v-if="row.has_xml">XML</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-success"
                                @click.prevent="clickDownload(row.download_cdr)" v-if="row.has_cdr">CDR</button>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-warning"
                                @click.prevent="clickTicket(row.id)" dusk="consult-ticket"
                                v-if="row.btn_ticket">Consultar</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                @click.prevent="clickDelete(row.id)" v-if="row.btn_ticket">Eliminar</button>
                        </td>
                    </tr>
                </data-table>
            </div>

            <summary-form :showDialog.sync="showDialog" :external="false"></summary-form>
        </div>
    </div>

</template>


<style>
.table-striped tr:nth-child(even) {
    background-color: #f5f5f5;
}
.table-striped tr:nth-child(odd) {
    background-color: #e7e1d6;
}
.table-striped th {
    background: #0d3557;
    color: #fff;
    padding: 10px 16px;
    font-size: 1rem;
    font-weight: bold;
    text-align: left;
    font-family: Arial, sans-serif;
}
.table-striped td {
    padding: 10px 16px;
    color: #18304b;
    font-size: 1rem;
    font-family: Arial, sans-serif;
}
</style>

<script>

import SummaryForm from './form.vue'
import DataTable from '../../components/DataTable.vue'
import { deletable } from '../../mixins/deletable'

export default {
    mixins: [deletable],
    components: { DataTable, SummaryForm },
    data() {
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
