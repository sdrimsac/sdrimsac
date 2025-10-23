<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Productos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista De promociones</span
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
                    <i class="fas fa-boxes"></i>
                    Listado De promociones
                </h4>
            </div>
            <div class="data-table-visible-columns">
                <el-button
                    type="primary"
                    class=""
                    href="javascript:void(0)"
                    @click.prevent="clickCreate()"
                >
                    <i class="fas fa-plus-circle"></i>
                    Nuevo
                </el-button>
            </div>
            <div class="card-body">
                <data-table ref="datatable" :resource="resource">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Cód. Interno</th>
                        <th class="text-white">Unidad</th>
                        <th class="text-white">Nombre</th>
                        <th class="text-white">Descripción</th>
                        <!-- <th class="text-white">Cód. SUNAT</th> -->
                        <!-- <th  class="text-left">Stock</th> -->
                        <th class="text-white text-right">
                            P.Unitario (Venta)
                        </th>
                        <th class="text-white text-center">Tiene Igv</th>
                        <th class="text-white text-right">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.internal_id }}</td>
                        <td>{{ row.unit_type_id }}</td>
                        <td>{{ row.description }}</td>
                        <td>{{ row.name }}</td>
                        <!-- <td>{{ row.item_code }}</td> -->
                        <!-- <td>
                            <template v-if="typeUser=='seller' && row.unit_type_id !='ZZ'">{{ row.stock }}</template>
                            <template v-else-if="typeUser!='seller'&& row.unit_type_id !='ZZ'">
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickWarehouseDetail(row.warehouses)"><i class="fa fa-search"></i></button>
                            </template>
                        </td> -->
                        <td class="text-right">{{ row.sale_unit_price }}</td>
                        <td class="text-center">
                            {{ row.has_igv_description }}
                        </td>
                        <td class="text-right">
                            <template
                                v-if="
                                    typeUser === 'admin' ||
                                        typeUser === 'superadmin'
                                "
                            >
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
                                        >Acciones
                                    </span>
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
                                        <i class="fa fa-edit"></i>
                                        Editar
                                    </a>

                                    <a
                                        type="button"
                                        class="dropdown-item text-danger"
                                        @click.prevent="clickDelete(row.id)"
                                    >
                                        <i class="fa fa-trash"></i>
                                        Eliminar
                                    </a>
                                    <a
                                        type="button"
                                        class="dropdown-item text-success"
                                        @click.prevent="clickWarehouse(row.id)"
                                    >
                                        <!-- <i class="fa fa-trash"></i> -->
                                        Receta en Todo los Almacenes
                                    </a>
                                </div>
                            </template>
                        </td>
                    </tr>
                </data-table>
            </div>

            <items-form
                :showDialog.sync="showDialog"
                :recordId="recordId"
            ></items-form>

            <items-import :showDialog.sync="showImportSetDialog"></items-import>

            <items-import-set-individual
                :showDialog.sync="showImportSetIndividualDialog"
            ></items-import-set-individual>

            <warehouses-detail
                :showDialog.sync="showWarehousesDetail"
                :warehouses="warehousesDetail"
            >
            </warehouses-detail>
        </div>
    </div>
</template>
<script>
import ItemsForm from "./form.vue";
import WarehousesDetail from "./partials/warehouses.vue";
import ItemsImport from "./import.vue";
import DataTable from "../../../../resources/js/components/DataTable.vue";
//'../../../components/DataTable.vue'
import { deletable } from "../../../../resources/js/mixins/deletable";
import ItemsImportSetIndividual from "./partials/import_set_individual.vue";

export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
        ItemsForm,
        ItemsImport,
        DataTable,
        WarehousesDetail,
        ItemsImportSetIndividual
    },
    data() {
        return {
            showDialog: false,
            showImportSetDialog: false,
            showImportSetIndividualDialog: false,
            showWarehousesDetail: false,
            resource: "promotions",
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
        clickImportSet() {
            this.showImportSetDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickWarehouse(id) {
            this.$http
                .get(`/${this.resource}/receta-warehouse/${id}`)
                .then(response => {
                    if (response.status == 200) {
                        this.$eventHub.$emit("reloadData");
                        this.$notify({
                            group: "foo",
                            title: "Receta",
                            text: response.data.message,
                            type: "success"
                        });
                    } else {
                        this.$notify({
                            group: "foo",
                            title: "Receta",
                            text: response.data.message,
                            type: "error"
                        });
                    }
                });
        }
    }
};
</script>
