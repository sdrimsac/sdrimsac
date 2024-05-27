<!-- Listado de Categorías -->
<template>
<div v-loading="loading">
    <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h6>
                        <span>Productos / {{ title }}</span>
                    </h6>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="text-muted">Productos / {{ title }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-sitemap"></i> Listado de {{ title }}
                </h4>
            </div>

            <div class="data-table-visible-columns">
                    <el-button type="primary" 
                                class="" 
                                href="javascript:void(0)" 
                                @click.prevent="clickCreate()">
                                <i class="fas fa-sitemap fa-lg"></i>
                                <i class="fa fa-plus"></i>
                            Nueva Categoría
                    </el-button>
                    <el-button type="primary" 
                                class="" 
                                href="javascript:void(0)" 
                                @click.prevent="clickImport()">
                                
                            <i class="fa fa-upload fa-lg"></i>
                            Importar
                    </el-button>

            </div> 
            <div class="card-body">
                <data-table :resource="resource" @clickReport="clickReport" class="table-striped">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Nombre</th>
                        <th class="text-white">Identificador</th>
                        <th class="text-white">Creado por</th>
                        <th class="text-white">Fecha creación</th>
                        <th class="text-white" v-if="configuration.pos_drag_category">
                            Caja arrastre
                        </th>
                        <th class="text-right text-white">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.identifier }}</td>
                        <td>
                            {{ row.user_name }}
                        </td>
                        <td>{{ row.created_at }}</td>
                        <td v-if="configuration.pos_drag_category">
                            <el-checkbox @change="changeDrag(row)" v-model="row.drag">
                            </el-checkbox>
                        </td>
                        <td class="text-right">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn btn-primary dropdown-toggle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay="0" title="" data-bs-original-title="Item Count" aria-label="Item Count">Acciones</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a type="button" class="dropdown-item text-secondary" @click.prevent="
                                     clickCreate(row.id)"> <i class="fa fa-edit"></i> Editar
                                </a>
                                <a type="button" class="dropdown-item text-danger" @click.prevent="
                                    clickDelete(row.id)"> <i class="fa fa-trash"></i> Eliminar
                                </a>
                            </div>

                           
                        </td>
                    </tr>
                </data-table>
            </div>

            <category-form :showDialog.sync="showDialog" :recordId="recordId"></category-form>
            <import-form :showDialog.sync="showImportDialog"></import-form>
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
import CategoryForm from "./form.vue";
import ImportForm from "./import.vue";
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
import {
    deletable
} from "../../../../../../../resources/js/mixins/deletable";
export default {
    props: ["configuration"],
    mixins: [deletable],
    components: {
        DataTable,
        CategoryForm,
        ImportForm
    },
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "items/categories",
            recordId: null,
            loading: false,
            showImportDialog: false
        };
    },
    created() {
        console.log(this.configuration);
        this.title = "Categorías";
    },
    methods: {
        clickImport() {
            this.showImportDialog = true;
        },
        clickReport(query = null) {
            let {
                column,
                value
            } = query;
            window.open(
                `/items/categories/export?column=${column ||
                    ""}&value=${value || ""}`,
                "_blank"
            );
        },
        async changeDrag(row) {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/update_drag/${row.id}`
                );
                if (response.status == 200) {
                    this.$message({
                        message: "Se ha actualizado correctamente",
                        type: "success"
                    });
                }
            } catch (e) {
                this.$message({
                    message: "Ha ocurrido un error",
                    type: "error"
                });
            } finally {
                this.loading = false;
            }
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
