<!-- Listado de Marcas de Productos -->
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
                            <span class="text-muted">Marcas</span>
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
                    <i class="fas fa-copyright"></i> Listado de {{ title }}
                </h4>
            </div>
            <div class="data-table-visible-columns">
                    <el-button type="primary" 
                                class="" 
                                href="javascript:void(0)" 
                                @click.prevent="clickCreate()">
                                <i class="fas fa-copyright fa-lg"></i>
                                <i class="fas fa-plus"></i>
                                Nueva Marca
                    </el-button>
            </div> 

            <div class="card-body">
                <data-table :resource="resource" @clickReport="clickReport"  class="table-striped">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Marca</th>
                        <th class="text-white">Fecha creación</th>
                        <th class="text-end text-white">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.created_at }}</td>



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
                            </div>
                        </td>
                    </tr>
                </data-table>
            </div>

            <category-form :showDialog.sync="showDialog" :recordId="recordId"></category-form>
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
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
import {
    deletable
} from "../../../../../../../resources/js/mixins/deletable";

export default {
    mixins: [deletable],
    components: {
        DataTable,
        CategoryForm
    },
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "brands",
            recordId: null
        };
    },
    created() {
        this.title = "Marcas de Productos";
    },
    methods: {
        clickReport(query = null) {
            let {
                column,
                value
            } = query;
            window.open(`/brands/export?column=${column||''}&value=${value||''}`, '_blank');
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
