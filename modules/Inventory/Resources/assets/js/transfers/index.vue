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

                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h4 class="my-0 text-white">
                        <i class="fa fa-crane"></i>                        
                        <i class="fa fa-dolly"></i>
                        Listado de {{ title }}
                    </h4>
                </div>
                <div class="data-table-visible-columns">
                        <el-button type="primary" 
                                    class="" 
                                    href="javascript:void(0)" 
                                    @click.prevent="clickCreate()">
                                    <i class="fa fa-dolly fa-lg"></i>
                                    <i class="fa fa-plus"></i>

                                    Nuevo Traslado
                        </el-button>
                </div> 
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white">Fecha</th>
                            <th class="text-white">Almacen Inicial</th>

                            <th class="text-white">Almacen Destino</th>
                            <th class="text-white">Detalle</th>
                            <th class="text-white">Detalle Productos</th>
                            <th class="text-white">Cantidad Total Productos</th>
                            <!--<th class="text-end">Acciones</th> -->
                        </tr>
                        <tr class="text-white"></tr>
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
