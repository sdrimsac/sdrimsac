<!-- Modulo de Colores y Tallas -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Colores & Tallas</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de Productos con colores &
                                    tallas</span
                                >
                            </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-tshirt"></i>
                    <i class="fas fa-palette"></i>
                    Colores & Tallas</h4>
            </div>
            <div class="data-table-visible-columns">
                            <el-button  type="primary" 
                                        class="btn btn-icon btn-icon-start w-100 w-md-auto" 
                                        href="javascript:void(0)" @click.prevent="clickImportColorSize()">
                                        <i class="fa fa-upload"></i>
                                        Importar
                            </el-button>
            </div> 
            <div class="card-body">
                <data-table class="table-striped" ref="datatable" :resource="resource">
                    <tr slot="heading" width="100%" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Código</th>
                        <th class="text-white">Producto</th>
                        <th class="text-white">Código familia</th>
                        <th class="text-white">Color</th>
                        <th class="text-white">Talla</th>
                        <th class="text-white">Stock</th>
                        <th class="text-white">Precio</th>
                        <th class="text-right text-white">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.item_internal_id }}</td>
                        <td>{{ row.item_description }}</td>
                        <td>{{ row.code }}</td>
                        <td>{{ row.color }}</td>
                        <td>{{ row.size }}</td>
                        <td>{{ row.stock }}</td>
                        <td>{{ row.price }}</td>

                        <td class="text-right">
                            <template
                                v-if="
                                    typeUser === 'admin' ||
                                        typeUser === 'superadmin'
                                "
                            >
                                <!-- <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-xs btn-info btn-sm"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    Editar
                                </button> -->
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-xs btn-danger btn-sm"
                                    @click.prevent="clickDelete(row.id)"
                                >
                                    Eliminar
                                </button>
                            </template>
                        </td>
                    </tr>
                </data-table>
            </div>

            <items-form
                :showDialog.sync="showDialog"
                :recordId="recordId"
            ></items-form>
            <import-color-size
                :showDialog.sync="showImportColorSizeDialog"
            ></import-color-size>
        </div>
    </div>
</template>

<style>

.table-striped tr:nth-child(even) {
background-color: #f2f2f2;
}
</style>

<script>
import ItemsForm from "./form.vue";
import ImportColorSize from "./import.vue";
import DataTable from "../../../../resources/js/components/DataTable.vue";
//'../../../components/DataTable.vue'
import { deletable } from "../../../../resources/js/mixins/deletable";

export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
        ItemsForm,
        DataTable,
        ImportColorSize
    },
    data() {
        return {
            showDialog: false,
            showImportColorSizeDialog: false,
            showImportSetIndividualDialog: false,
            showWarehousesDetail: false,
            resource: "item-color-size",
            recordId: null,
            warehousesDetail: []
        };
    },
    created() {},
    methods: {
        clickImportSetIndividual() {
            this.showImportSetIndividualDialog = true;
        },
        clickWarehouseDetail(warehouses) {
            this.warehousesDetail = warehouses;
            this.showWarehousesDetail = true;
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickImportColorSize() {
            this.showImportColorSizeDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
