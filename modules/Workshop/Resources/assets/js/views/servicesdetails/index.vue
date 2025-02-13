<!-- Listado de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>Servicios</h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Servicios</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-university"></i> Listado De Servicios
                </h4>
                <div class="card-actions white-text">
                    <a
                        href="#"
                        class="card-action card-action-toggle text-white"
                        data-card-toggle
                    ></a>
                    <a
                        href="#"
                        class="card-action card-action-dismiss text-white"
                        data-card-dismiss
                    ></a>
                </div>
            </div>
            <div class="data-table-visible-columns">
                <el-button
                    type="primary"
                    class
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                    >Nuevo Servicio</el-button
                >
            </div>
            <div class="">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-bold"
                                    >Tipo de Servicio</label
                                >
                                <el-select
                                    v-model="form.service_id"
                                    placeholder="Seleccione un tipo de servicio"
                                    @change="getData"
                                    clearable
                                >
                                    <el-option
                                        v-for="item in service"
                                        :key="item.id"
                                        :label="item.description"
                                        :value="item.id"
                                    ></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-bold"
                                    >Nombre Del Servicio</label
                                >
                                <el-input
                                    v-model="form.name"
                                    @input="getData"
                                    placeholder="Ingrese Nombre del servicio"
                                ></el-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Tipo Servicio</th>
                                <th class="text-white">Servico</th>
                                <th class="text-white">
                                    Observacion o trabajo Rea.
                                </th>
                                <th class="text-white">Precio</th>
                                <th class="text-white text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, index) in records"
                                :key="customIndex(index)"
                            >
                                <td>{{ customIndex(index) }}</td>
                                <td>{{ row.service_description }}</td>
                                <td>{{ row.name }}</td>
                                <td>{{ row.description }}</td>
                                <td>{{ row.price_unit }}</td>
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
                                            title
                                            data-bs-original-title="Item Count"
                                            aria-label="Item Count"
                                            >Acciones</span
                                        >
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        style
                                    >
                                        <a
                                            type="button"
                                            class="dropdown-item text-secondary"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <template>
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
                <div>
                    <el-pagination
                        @current-change="handlePageChange"
                        layout="total, prev, pager, next"
                        :total="pagination.total"
                        :current-page="pagination.current_page"
                        :page-size="pagination.per_page"
                    >
                    </el-pagination>
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
            pagination: {},
            title: "",
            showDialog: false,
            resource: "workshop",
            recordId: null,
            records: [],
            services: [],
            service: {},
            form: {
                service_id: "",
                name: ""
            }
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
            this.getTables();
        });
        this.getData();
        this.getTables();
    },
    methods: {
        handlePageChange(page) {
            this.pagination.current_page = page;
            this.getData();
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                (index + 1)
            );
        },
        getTables() {
            this.$http
                .get(`/${this.resource}/servicesdetails/tables`)
                .then(response => {
                    this.service = response.data.service;
                });
        },
        getData() {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            this.searchTimeout = setTimeout(() => {
                this.$http
                    .get(`/${this.resource}/servicesdetails/records`, {
                        params: {
                            service_id: this.form.service_id,
                            name: this.form.name,
                            page: this.pagination.current_page
                        }
                    })
                    .then(response => {
                        this.records = response.data.data;
                        this.pagination = response.data.meta;
                        this.pagination.per_page = parseInt(
                            response.data.meta.per_page
                        );
                    });
            }, 300);
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
