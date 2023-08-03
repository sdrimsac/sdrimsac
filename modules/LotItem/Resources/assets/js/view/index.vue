<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Series (productos)</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Series de productos</span
                                >
                            </li>
                        </ol>
                    </div>
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <!-- Contact Button Start -->
                        <!-- <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start btn-sm"
                        >
                            <i data-cs-icon="plus"></i>
                            <span>Nuevo</span>
                        </button> -->
                        <button
                            class="btn btn-sm btn-icon btn-icon-only btn-outline-primary align-top float-end"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-haspopup="true"
                        >
                            <i data-cs-icon="more-horizontal"></i>
                        </button>
                        <div
                            class="dropdown-menu dropdown-menu-sm dropdown-menu-end"
                        >
                            <a
                                class="dropdown-item"
                                href="javascript:void(0)"
                                @click.prevent="clickImport()"
                            >
                                <i class="fa fa-upload"></i> Importar</a
                            >
                            <!-- <a
                                class="dropdown-item"
                                href="javascript:void(0)"
                            >
                                <i class="fa fa-upload"></i> Importar lista de
                                precios</a
                            > -->
                        </div>
                        <!-- <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" @click.prevent="clickCreate()">
                        <i class="icofont-plus-circle"></i>
                        <span>Nuevo</span>
                    </button>

                    <div class="btn-group flex-wrap">
                    <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-upload"></i> Importar <span class="caret"></span></button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                        <a class="dropdown-item" href="#" @click.prevent="clickImport()">Importar Productos</a>
                    </div>
                 </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h6 class="my-0  text-white">
                                Listado Series (productos)
                            </h6>
                        </div>
                        <div class="data-table-visible-columns">
                            <el-dropdown :hide-on-click="false">
                                <el-button type="primary">
                                    Mostrar/Ocultar columnas<i
                                        class="el-icon-arrow-down el-icon--right"
                                    ></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item
                                        v-for="(column, index) in columns"
                                        :key="index"
                                    >
                                        <el-checkbox v-model="column.visible">{{
                                            column.title
                                        }}</el-checkbox>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </div>
                        <div class="card-body">
                            <data-table ref="datatable" :resource="resource">
                                <tr slot="heading">
                                    <th>#</th>
                                    <th>Serie</th>
                                    <th>
                                        Producto
                                    </th>
                                    <th>Fecha</th>
                                    <th>
                                        Almacén
                                    </th>
                                    <th>Vendido</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>

                                <tr></tr>
                                <tr slot-scope="{ index, row }">
                                    <td>
                                        {{ index }}
                                    </td>
                                    <td>
                                        {{ row.series }}
                                    </td>
                                    <td>
                                        {{ row.item.description }}
                                    </td>
                                    <td>
                                        {{ row.date }}
                                    </td>
                                    <td>
                                        {{ row.warehouse.description }}
                                    </td>
                                    <td>
                                        {{ row.has_sale ? "Sí" : "No" }}
                                    </td>
                                    <td>
                                        {{ row.active }}
                                    </td>
                                    <td>
                                        <el-button
                                            size="mini"
                                            type="success"
                                            @click="editSerie(row.id)"
                                            >Editar</el-button
                                        >
                                        <el-button
                                            size="mini"
                                            type="danger"
                                            @click="removeSerie(row.id)"
                                            >Eliminar</el-button
                                        >
                                    </td>
                                </tr>
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <series-import :showDialog.sync="showImportDialog"></series-import>

        <form-serie-edit
            :showDialog.sync="showFormDialog"
            :recordId.sync="recordId"
            @reload="reload"
        >
        </form-serie-edit>
    </div>
</template>

<script>
const FormSerieEdit = () => import("./form_edit.vue");
import DataTable from "../components/Datatable.vue";
import SeriesImport from "./series_import.vue";
export default {
    components: { DataTable, SeriesImport, FormSerieEdit },
    data() {
        return {
            resource: "lotitem",
            columns: {},
            showImportDialog: false,
            recordId: null,
            showFormDialog: false
        };
    },
    methods: {
        reload() {
            this.$refs.datatable.getRecords();
        },
        clickImport() {
            this.showImportDialog = true;
        },
        editSerie(id) {
            this.recordId = id;
            this.showFormDialog = true;
        },
        async removeSerie(id) {
            try {
                await this.$confirm(
                    "¿Está seguro de eliminar el registro?",
                    "Eliminar",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                );
                const response = await this.$http.get(`/lotitem/delete/${id}`);
                if (response.data.success) {
                    this.$toast({
                        message: response.data.message,
                        type: "success"
                    });
                    this.$refs.datatable.getRecords();
                } else {
                    this.$toast({
                        message: response.data.message,
                        type: "error"
                    });
                }
            } catch (e) {}
        }
    }
};
</script>
