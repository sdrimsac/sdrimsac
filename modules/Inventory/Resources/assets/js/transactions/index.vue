<!-- Listado de Transacciones -->
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
                <h4 class="my-0 text-white"><i class="fas fa-list-ul"></i> Listado de {{ title }}</h4>

            </div>
            <div class="data-table-visible-columns">
                    <el-button type="primary" 
                                class="" 
                                href="javascript:void(0)" 
                                @click.prevent="clickCreate()">
                                <i class="fas fa-list-ul fa-lg"></i>
                                <i class="fas fa-plus"></i>
                            Nueva Transacción
                    </el-button>
            </div> 

            <div class="card-body">
                
                <data-table :resource="resource" class="table-striped">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Descripción</th>
                        <th class="text-white">Tipo</th>
                        <th class="text-white text-end">Acciones</th>
                    </tr>
                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.name }}</td>

                        <td :style="{ color: row.color }">{{ row.type }}</td>

                        <td class="text-end">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a type="button" class="dropdown-item text-secondary" @click.prevent=" clickCreate(row.id)"> <i class="fa fa-edit"></i> Editar
                                </a>
                                <a type="button" class="dropdown-item text-danger" @click.prevent="
                                    clickDelete(row.id)"> <i class="fa fa-trash"></i> Eliminar
                                </a>
                                <!-- <a type="button" class="dropdown-item text-warning" @click.prevent="
                                    clickDisable(row.id)" v-if="row.active">Inhabilitar
                                </a>
                                <a type="button" class="dropdown-item text-success" @click.prevent="
                                    clickEnable(row.id)" v-else>Habilitar
                                </a> -->
                            </div>

                            <!-- <div class="btn-group">
                                <el-tooltip class="item" effect="dark" content="Editar" placement="bottom-end">
                                    <button type="button" class="btn btn-primary btn-icon btn-icon-start" @click.prevent="clickCreate(row.id)">
                                        <i class="icofont-edit"></i>
                                    </button>
                                </el-tooltip>
                                <el-tooltip class="item" effect="dark" content="Eliminar" placement="bottom-end">
                                    <button type="button" class="btn btn-danger btn-icon btn-icon-start" @click.prevent="clickDelete(row.id)">
                                        <i class="icofont-trash"></i>
                                    </button>
                                </el-tooltip>
                            </div> -->
                        </td>

                    </tr>
                </data-table>
            </div>

            <inventory-transaction :showDialog.sync="showDialog" :recordId="recordId"></inventory-transaction>
        </div>
    </div>
</div>
</template>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}
</style>

<script>
import DataTable from "../../../../../../resources/js/components/DataTableTransactions.vue";
import {
    deletable
} from "../../../../../../resources/js/mixins/deletable";
import InventoryTransaction from "./form.vue";

export default {
    components: {
        DataTable,
        InventoryTransaction
    },
    mixins: [deletable],
    props: ["configuration"],
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "transactions",
            recordId: null,
            typeTransaction: null,
            direct: false
        };
    },
    created() {
        this.title = "Transacciones";
        this.direct = this.configuration.translate_direct;
    },
    methods: {
        clickCreate(recordId = null) {
            this.recordId = recordId
            this.showDialog = true
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
