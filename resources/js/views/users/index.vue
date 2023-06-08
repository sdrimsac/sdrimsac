<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Cuenta de Usuarios</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Usuarios</span>
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
            <div class="card">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th>Nombre</th>
                                    <th>Perfil</th>
                                    <th>Api Token</th>
                                    <th>Establecimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(row, index) in records"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ row.email }}</td>
                                    <td>{{ row.name }}</td>
                                    <td>{{ row.type }}</td>
                                    <td>{{ row.api_token }}</td>
                                    <td>{{ row.establishment_description }}</td>
                                    <td class="text-end">
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-info"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                            @click.prevent="clickDelete(row.id)"
                                            v-if="row.id != 1"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <users-form
                    :showDialog.sync="showDialog"
                    :typeUser="typeUser"
                    :type="type"
                    :recordId="recordId"
                ></users-form>
            </div>
        </div>
    </div>
</template>

<script>
import UsersForm from "./form1.vue";
import { deletable } from "../../mixins/deletable";

export default {
    props: ["typeUser", "type"],
    mixins: [deletable],
    components: { UsersForm },
    data() {
        return {
            showDialog: false,
            resource: this.type,
            recordId: null,
            records: [],
            title: null
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
        if (this.type == "drivers") {
            this.title = "Conductores de Vehiculos";
        } else if (this.type == "users") {
            this.title = "Usuarios";
        }
    },
    methods: {
        getData() {
            this.$http
                .get(`/${this.resource}/${this.type}/records`)
                .then(response => {
                    this.records = response.data.data;
                });
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
