<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Productos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista De Platos vendidos</span
                                >
                            </li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-boxes"></i>
                    Listado De Platos Vendidos</h4>
            </div>
            <div class="card-body">
                <data-table ref="datatable" :resource="resource">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Cantidad</th>
                        <th class="text-white">Descripción</th>
                        <th class="text-white">precio</th>
                        <th class="text-white">Total</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.description }}</td>
                        <td>{{ Number(row.quantity).toFixed(2) }}</td>
                        <td>{{ Number(row.price).toFixed(2) }}</td>
                        <td>{{ Number(row.total).toFixed(2) }}</td>
                    </tr>
                </data-table>
            </div>

        </div>
    </div>
</template>
<script>
//'../../../components/DataTable.vue'
import { deletable } from "../../../../resources/js/mixins/deletable";
import DataTable from "../../components/DataTableFood.vue";


export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
        DataTable
       
    },
    data() {
        return {
            resource: "foods",
        };
    },
    created() {
     
    },
    methods: {

    }
};
</script>
