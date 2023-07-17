<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-6">
                        <h6>
                            <span>{{ title }}</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">{{ title }}</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <div>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Nuevo"
                                placement="bottom-end"
                            >
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                                    @click.prevent="clickCreate()"
                                >
                                    <i class="icofont-plus-circle"></i>
                                    <span>Nuevo</span>
                                </button>
                            </el-tooltip>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Almacen Inicial</th>

                            <th>Almacen Destino</th>
                            <th>Detalle</th>
                            <th>Detalle Productos</th>
                            <th>Cantidad Total Productos</th>
                            <!--<th class="text-end">Acciones</th> -->
                        </tr>
                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.created_at }}</td>

                            <td>{{ row.warehouse }}</td>
                            <td>{{ row.warehouse_destination }}</td>
                            <td>{{ row.description }}</td>
                            <td>
                                <el-popover
                                    placement="right"
                                    width="400"
                                    trigger="click"
                                >
                                    <el-table :data="row.inventory">
                                        <el-table-column
                                            width="260"
                                            property="description"
                                            label="Producto"
                                        ></el-table-column>

                                        <el-table-column
                                            width="100"
                                            property="quantity"
                                            label="Cantidad"
                                        ></el-table-column>

                                        <el-table-column
                                            fixed="right"
                                            label="Series"
                                            width="120"
                                        >
                                            <template slot-scope="scope">
                                                <el-popover
                                                    placement="right"
                                                    width="150"
                                                    trigger="click"
                                                >
                                                    <el-table
                                                        :data="scope.row.lots"
                                                        width="80"
                                                    >
                                                        <el-table-column
                                                            prop="series"
                                                            label="Series"
                                                            width="180"
                                                        ></el-table-column>
                                                    </el-table>
                                                    <el-button
                                                        slot="reference"
                                                        icon="el-icon-zoom-in"
                                                    ></el-button>
                                                </el-popover>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <el-button
                                        slot="reference"
                                        icon="el-icon-zoom-in"
                                    ></el-button>
                                </el-popover>
                            </td>
                            <td>{{ row.quantity }}</td>
                            <!--<td class="text-end">
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                        @click.prevent="clickCreate(row.id)">Editar</button>
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDelete(row.id)">Eliminar</button>
                </td>-->
                        </tr>
                    </data-table>
                </div>

                <inventories-form
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                    :isDirect="direct"
                ></inventories-form>
            </div>
        </div>
    </div>
</template>

<script>
import DataTable from "../../../../../../resources/js/components/DataTableTransfers.vue";
import { deletable } from "../../../../../../resources/js/mixins/deletable";
import InventoriesForm from "./form.vue";

export default {
    components: { DataTable, InventoriesForm },
    mixins: [deletable],
    props: ["configuration"],
    data() {
        return {
            title: null,
            showDialog: false,
            resource: "transfers",
            recordId: null,
            typeTransaction: null,
            direct:false
        };
    },
    created() {
        this.title = "Traslados";
        this.direct = this.configuration.translate_direct;
    },
    methods: {
        clickCreate(recordId = null) {
            location.href = `/${this.resource}/create`;
            //this.recordId = recordId
            //this.showDialog = true
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
