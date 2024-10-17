<!-- Listado de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            Personal Mecanico
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Listado Personal</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-university"></i> Listado Mecanico
                </h4>
                <div class="card-actions white-text">
                    <a
                        href="#"
                        class="card-action card-action-toggle text-white"
                        data-card-toggle=""
                    ></a>
                    <a
                        href="#"
                        class="card-action card-action-dismiss text-white"
                        data-card-dismiss=""
                    ></a>
                </div>
            </div>
            <div class="data-table-visible-columns">
                <el-button
                    type="primary"
                    class=""
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                >
                    Nuevo Personal
                </el-button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Nombre</th>
                                <th class="text-white">DNI</th>
                                <th class="text-white">Telefono</th>
                                <th class="text-white text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in records" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.number }}</td>
                                <td>{{ row.telephone }}</td>
                                <td class="text-end">
                                    <button
                                        class="btn p-0"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <span
                                            class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-delay="0"
                                            title=""
                                            data-bs-original-title="Item Count"
                                            aria-label="Item Count"
                                            >Acciones</span
                                        >
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        style=""
                                    >
                                        <a
                                            type="button"
                                            class="dropdown-item text-secondary"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <template
                                            v-if="
                                                typeUser === 'admin' ||
                                                    typeUser === 'superadmin'
                                            "
                                        >
                                            <a
                                                type="button"
                                                class="dropdown-item text-danger"
                                                @click.prevent="
                                                    clickDelete(row.id)
                                                "
                                            >
                                                <i class="fa fa-trash"></i>
                                                Eliminar
                                            </a>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <workshop-form
                :showDialog.sync="showDialog"
                :recordId="recordId"
            ></workshop-form>
        </div>
    </div>
</template>

<script>
import WorkshopForm from "./form.vue";
/* import { deletable } from "../../mixins/deletable"; */
import { deletable } from "../../../../../../../resources/js/mixins/deletable";

export default {
    mixins: [deletable],
    props: ["typeUser"],
    components: {
        WorkshopForm
    },
    data() {
        return {
            title: "",
            showDialog: false,
            resource: "workshop/mecanico",
            recordId: null,
            records: []
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
    },
    methods: {
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
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
