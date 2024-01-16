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
                                <span class="text-muted">Transformados</span>
                            </li>
                        </ol>
                    </div>
                    <!-- <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            @click.prevent="clickCreate()"
                        >
                            <i class="icofont-plus-circle"></i>
                            <span>Nuevo</span>
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource" @clickReport="clickReport">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.description }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="
                                        clickWarehouseDetail(
                                            row.id,
                                            row.has_series,
                                            row.warehouses,
                                            row.unit_type,
                                            row
                                        )
                                    "
                                >
                                    <i class="fa fa-search"></i>
                                </button>
                            </td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickCreate(row.id)"
                                >
                                    Crear
                                </button>
                                <!-- <button
                                    type="button"
                                    class="btn waves-effect waves-light btn-sm btn-danger"
                                    @click.prevent="clickDelete(row.id)"
                                >
                                    Eliminar -->
                                <!-- </button> -->
                            </td>
                        </tr>
                    </data-table>
                </div>
                <manufactured-form
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                >
                </manufactured-form>
                   <warehouses-detail
                    :showDialog.sync="showWarehousesDetail"
                    :unit_type.sync="unit_type"
                    :warehouses="warehousesDetail"
                    :hasSerie="hasSerie"
                    :itemId="itemId"
                    :item="currentItem"
                >
                </warehouses-detail>
            </div>
        </div>
    </div>
</template>

<script>
import ManufacturedForm from "./form.vue";
import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
import WarehousesDetail from "../../../../../../../resources/js/views/items/partials/warehouses.vue";
export default {
    mixins: [deletable],
    components: { DataTable, ManufacturedForm, WarehousesDetail },
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "manufactured",
            recordId: null,
            currentItem: null,
            itemId: null,
            hasSerie: null,
            warehousesDetail: null,
            unit_type: null,
            showWarehousesDetail: false,
        };
    },
    created() {
        this.title = "Productos transformados";
    },
    methods: {
        clickWarehouseDetail(id, hasSerie, warehouses, unit_type, item) {
            this.currentItem = item;
            this.itemId = id;
            this.hasSerie = hasSerie;

            this.warehousesDetail = warehouses;
            this.unit_type = unit_type;
            this.showWarehousesDetail = true;
        },
        clickReport(query = null) {
            let { column, value } = query;
            window.open(
                `/manufactured/export?column=${column || ""}&value=${value ||
                    ""}`,
                "_blank"
            );
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
