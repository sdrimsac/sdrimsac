<template>
    <div>
        <!-- <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Productos</span></li>
            </ol>
            <div class="right-wrapper pull-right">
                <div class="btn-group flex-wrap">
                    <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-upload"></i> Importar <span class="caret"></span></button>
                    <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 42px, 0px);">
                        <a class="dropdown-item text-1" href="#" @click.prevent="clickImportSet()">1. Productos compuestos</a>
                        <a class="dropdown-item text-1" href="#" @click.prevent="clickImportSetIndividual()">2. Detalle productos compuestos</a>
                    </div>
                </div>
                <template>
                     <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nuevo</button>
                </template>
            </div>
        </div> -->
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
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <!-- Contact Button Start -->

                        <!-- <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            @click.prevent="clickCreate()"
                        >
                            <i data-cs-icon="plus"></i>
                            <span>Nuevo</span>
                        </button> -->
                        <!-- <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" @click.prevent="clickImportSet()">
                     <i class="fa fa-upload"></i>
                    <span>Importar Productos compuestos</span>
                    </button> -->
                        <!-- Contact Button End -->
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-header bg-secondary">
                <h6 class="my-0 text-white">Colores & Tallas</h6>
            </div>
            <div class="card-body">
                <data-table ref="datatable" :resource="resource">
                    <tr slot="heading" width="100%">
                        <th>#</th>
                        <th>Producto</th>
                        <th>Color</th>
                        <th>Talla</th>
                        <th>Stock</th>

                        <th class="text-right">Acciones</th>
                    </tr>

                    <tr></tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.item_description }}</td>
                        <td>{{ row.color }}</td>
                        <td>{{ row.size }}</td>
                        <td>{{ row.stock }}</td>

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
        </div>
    </div>
</template>
<script>
import ItemsForm from "./form.vue";
import DataTable from "../../../../resources/js/components/DataTable.vue";
//'../../../components/DataTable.vue'
import { deletable } from "../../../../resources/js/mixins/deletable";

export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
        ItemsForm,
        DataTable
    },
    data() {
        return {
            showDialog: false,
            showImportSetDialog: false,
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
        clickImportSet() {
            this.showImportSetDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
