<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-6">
                        <h6>
                            <span>{{ title }}</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">{{ title }}</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Almacen Inicial</th>
                            <th>Almacen Destino</th>
                            <th>Usuario remitente</th>
                            <th>Código</th>
                            <th>Cantidad Total</th>
                            <th>Estado</th>
                        </tr>
                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.created_at }}</td>
                            <td>{{ row.warehouse }}</td>
                            <td>{{ row.warehouse_destination }}</td>
                            <td>{{ row.sender }}</td>
                            <td>
                                {{ row.code }}
                            </td>
                            <td>{{ row.quantity }}</td>
                            <td>
                                {{ row.status == 1 ? "Enviado" : "Aceptado" }}
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../../../../../resources/js/components/DataTableTransfers.vue";
import { deletable } from "../../../../../../resources/js/mixins/deletable";

export default {
    components: { DataTable },
    mixins: [deletable],
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "transfers/transfer_place",
            recordId: null,
            typeTransaction: null
        };
    },
    created() {
        this.title = "Traslados por aceptar";
    },
    methods: {
        clickCreate(recordId = null) {
            location.href = `/${this.resource}/create`;
            //this.recordId = recordId
            //this.showDialog = true
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
