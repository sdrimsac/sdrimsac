<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>{{ title }}</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">{{ title }}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Pedidoss</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="bookmark">
                            <ul>
                                <!-- <li  v-if="typeUser != 'integrator'"> -->
                                <li>
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Nuevo"
                                        placement="bottom-end"
                                    >
                                        <a
                                            href="javascript:void(0)"
                                            @click.prevent="clickCreate()"
                                            data-container="body"
                                            data-bs-toggle="popover"
                                            data-placement="top"
                                            data-original-title="Tables"
                                        >
                                            Nuevo
                                            <i data-feather="plus-circle"></i>
                                        </a>
                                    </el-tooltip>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">{{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Establecimiento</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.description }}</td>
                            <td>{{ row.establishment_description }}</td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    Editar
                                </button>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <warehouses-form
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                ></warehouses-form>
            </div>
        </div>
    </div>
</template>

<script>
import WarehousesForm from "./form.vue";
import DataTable from "../../../../../../resources/js/components/DataTable.vue";

export default {
    props: ["type"],
    components: { DataTable, WarehousesForm },
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "warehouses",
            recordId: null
        };
    },
    created() {
        this.title = "Listado de almacenes";
    },
    methods: {
        clickCreate(recordId) {
            this.recordId = recordId;
            this.showDialog = true;
        }
    }
};
</script>
