<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span> {{ title }}</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"> {{ title }}</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="bookmark">
                            <ul>
                                <li v-if="typeUser != 'integrator'">
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
                            <th>Fecha registro</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.description }}</td>
                            <td>{{ row.created_at }}</td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    Editar
                                </button>
                                <template
                                    v-if="
                                        typeUser === 'admin' ||
                                            typeUser === 'superadmin'
                                    "
                                >
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDelete(row.id)"
                                    >
                                        Eliminar
                                    </button>
                                </template>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <person-types-form
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                ></person-types-form>
            </div>
        </div>
    </div>
</template>

<script>
import PersonTypesForm from "./form.vue";
import DataTable from "../../components/DataTable.vue";
import { deletable } from "../../mixins/deletable";

export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: { PersonTypesForm, DataTable },
    data() {
        return {
            title: null,
            showDialog: false,
            showImportDialog: false,
            resource: "person-types",
            recordId: null
        };
    },
    created() {
        this.title = "Tipos de clientes";
    },
    methods: {
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickImport() {
            this.showImportDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
