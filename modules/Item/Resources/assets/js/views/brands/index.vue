<!--Módulo de Marcas de Productos -->
<template>
    <div class="card mb-0">
        <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
            <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1.5rem; font-weight: bold;">
                <i class="fas fa-coins" style="font-size: 2rem; margin-right: 0.5rem;"></i>
                Módulo de {{ title }}
            </h4>
        </div>
        <div class="data-table-visible-columns" >
            <el-button class="btn_titulos_modal" href="javascript:void(0)" @click.prevent="clickCreate()">
                <i class="fas fa-coins"></i>
                <i class="fa fa-plus"></i>
                <span style="color: #000; font-size: 1.25rem; font-weight: bold;">Nuevo</span>
            </el-button>
        </div>

        <div class="card-body">
            <data-table :resource="resource" @clickReport="clickReport" class="table-striped">
                <tr slot="heading" class="bg-primary">
                    <th class="text-white">#</th>
                    <th class="text-white">Marca</th>
                    <th class="text-white">Creado Por Usuario</th>
                    <th class="text-white">Fecha creación</th>
                    <th class="text-end text-white">Acciones</th>
                </tr>

                <tr></tr>
                <tr slot-scope="{ index, row }">
                    <td>{{ index }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.user_name }}</td>
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


</template>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}
</style>

<script>
import CategoryForm from "./form.vue";
import DataTable from "../../../../../../../resources/js/components/DataTableMarca.vue";
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
