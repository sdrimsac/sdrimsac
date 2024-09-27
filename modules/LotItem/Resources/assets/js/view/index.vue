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
                            <span class="text-muted">Series de productos</span>
                        </li>
                    </ol>
                </div>
                <!-- <div class="col-12 col-md-6 d-flex align-items-start justify-content-end">
                    <button class="btn btn-sm btn-icon btn-icon-only btn-outline-primary align-top float-end" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                        <i data-cs-icon="more-horizontal"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                        <a class="dropdown-item" href="javascript:void(0)" @click.prevent="clickImport()">
                            <i class="fa fa-upload"></i> Importar</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-0">
                    <div class="card-header bg-primary rounded-top">
                        <h4 class="my-0  text-white">
                            <i class="fas fa-list-ol"></i>
                            Listado Series (productos)
                        </h4>
                    </div>
                    <div class="data-table-visible-columns">
                            <el-button type="primary" class="" href="javascript:void(0)" @click.prevent="clickImport()">
                                <i class="fa fa-upload"></i>
                                Importar
                            </el-button>
                    </div> 
                    <div class="card-body">
                        <data-table ref="datatable" :resource="resource">
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Codigo Interno</th>
                                <th class="text-white">Serie</th>
                                <th class="text-white">Producto</th>
                                <th class="text-white">Fecha</th>
                                <th class="text-white">Almacén</th>
                                <th class="text-white">Vendido</th>
                                <th class="text-white">Estado</th>
                                <th class="text-white text-end">Opciones</th>
                            </tr>

                            <tr></tr>
                            <tr slot-scope="{ index, row }">
                                
                                <td>{{ index }}</td>
                                <td>{{ row.item.internal_id }}</td>
                                <td>{{ row.series }}</td>
                                <td>{{ row.item.description }}</td>
                                <td>{{ row.date }}</td>
                                <td>{{ row.warehouse.description }}</td>
                                <td>{{ row.has_sale ? "Sí" : "No" }}</td>
                                <td>{{ row.active }}</td>
                                <td class="text-end">
                                   
                                    <button class="btn p-0" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-haspopup="true" 
                                            aria-expanded="false">
                                            <span   class="btn btn-primary dropdown-toggle" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top"    
                                                    data-bs-delay="0" 
                                                    title="" 
                                                    data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a  type="button" 
                                        class="dropdown-item text-secondary"
                                        @click.prevent="editSerie(row.id)"> 
                                        <i class="fa fa-edit"></i>
                                         Editar
                                    </a>
                                    
                                    <a  type="button" 
                                        class="dropdown-item text-danger" 
                                        @click.prevent="removeSerie(row.id)"> 
                                        <i class="fa fa-trash"></i> Eliminar
                                    </a>

                                    </div>
                                </td>
                            </tr>
                        </data-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <series-import :showDialog.sync="showImportDialog"></series-import>

    <form-serie-edit :showDialog.sync="showFormDialog" :recordId.sync="recordId" @reload="reload">
    </form-serie-edit>
</div>
</template>

<script>
const FormSerieEdit = () => import("./form_edit.vue");
import DataTable from "../components/Datatable.vue";
import SeriesImport from "./series_import.vue";
export default {
    components: {
        DataTable,
        SeriesImport,
        FormSerieEdit
    },
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
                    "Eliminar", {
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
