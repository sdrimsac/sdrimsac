<!-- Modulo de Colores y Tallas -->
<template>
    <div>
        
        <div class="card mb-0">

            <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
                <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1.5rem; font-weight: bold;">
                    <i class="fas fa-tshirt" style="font-size: 2rem; margin-right: 0.5rem;"></i>
                    Colores & Tallas
                </h4>
            </div>
            <div class="data-table-visible-columns">
                <!-- <el-button type="" class="btn_buscar" href="javascript:void(0)"
                    @click.prevent="clickImportColorSize()">
                    <i class="fa fa-upload"></i>
                    Importar
                </el-button> -->
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
                        <th class="text-white">Estado</th>
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
                        <td>
                            <span :class="{ 'text-danger': row.stock === 0, 'text-success': row.stock > 0 }">
                                {{ row.stock === 0 ? 'Agotado' : 'Disponible' }}
                            </span>
                        </td>

                        <td class="text-right">
                            <template v-if="
                                typeUser === 'admin' ||
                                typeUser === 'superadmin'
                            ">
                                <!-- <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-xs btn-info btn-sm"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    Editar
                                </button> -->
                                <!-- <button type="button" class="btn waves-effect waves-light btn-xs btn-danger btn-sm"
                                
                                    @click.prevent="clickDelete(row.id)">
                                    Eliminar
                                </button> -->
                            </template>
                        </td>
                    </tr>
                </data-table>
            </div>

            <items-form :showDialog.sync="showDialog" :recordId="recordId"></items-form>
            <import-color-size :showDialog.sync="showImportColorSizeDialog"></import-color-size>
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
            warehousesDetail: [],
            warehouses: [],
        };
    },
    created() {
    },
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
        },
    }
};
</script>
