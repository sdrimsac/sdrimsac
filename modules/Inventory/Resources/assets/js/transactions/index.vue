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
                    <div class="col-6 d-flex justify-content-end">
                        <div>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Nuevo"
                                placement="bottom-end"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                                    @click.prevent="clickCreate()"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </el-tooltip>
                        </div>
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
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.name }}</td>

                            <td>{{ row.type }}</td>
                            <td>
                              <div class="btn-group">
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Editar"
                                    placement="bottom-end"
                                >
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-icon btn-icon-start"
                                        @click.prevent="clickCreate(row.id)"
                                    >
                                        <i class="icofont-edit"></i>
                                    </button>
                                </el-tooltip>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Eliminar"
                                    placement="bottom-end"
                                >
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-icon btn-icon-start"
                                        @click.prevent="clickDelete(row.id)"
                                    >
                                        <i class="icofont-trash"></i>
                                    </button>
                                </el-tooltip>
                                </div>
                            </td>
                  
                        </tr>
                    </data-table>
                </div>

                <inventory-transaction
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                ></inventory-transaction>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../../../../../resources/js/components/DataTableTransactions.vue";
import { deletable } from "../../../../../../resources/js/mixins/deletable";
import InventoryTransaction from "./form.vue";

export default {
    components: { DataTable, InventoryTransaction },
    mixins: [deletable],
    props: ["configuration"],
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "transactions",
            recordId: null,
            typeTransaction: null,
            direct:false
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
