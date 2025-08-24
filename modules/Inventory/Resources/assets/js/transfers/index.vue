<!-- Listado de Traslados Adminsitrador -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
                    <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1.5rem; font-weight: bold;">
                        <i class="fa fa-dolly" style="font-size: 2rem; margin-right: 0.5rem;"></i>
                        Listado de {{ title }}
                    </h4>
                </div>
                <div class="data-table-visible-columns d-flex justify-content-start align-items-center mb-3"
                    style="margin-left: 1rem;">
                    <el-button class="btn_buscar me-2" href="javascript:void(0)" @click.prevent="clickCreate()">
                        <i class="fas fa-plus"></i>
                        <span style="color: #fff; font-size: 1.25rem; font-weight: bold;">Nuevo Traslado de
                            Productos</span>
                    </el-button>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white">Fecha</th>
                            <th class="text-white">
                                Almacen Inicial
                                <span class="badge bg-success">Origen</span>
                            </th>
                            <th class="text-white">
                                Almacen Destino
                                <span class="badge bg-danger">Destino</span>
                            </th>
                            <th class="text-white">Motivo del Traslado</th>
                            <th class="text-white">Contenido del Traslado</th>
                            <th class="text-white">Unidades Trasladadas</th>
                            <!-- <th class="text-white">Acciones</th> -->
                        </tr>
                        <tr class="text-white"></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.created_at }}</td>

                            <td>{{ row.warehouse }}</td>
                            <td>{{ row.warehouse_destination }}</td>
                            <td>{{ row.description }}</td>
                            <td>
                                <el-popover placement="right" width="400" trigger="click">
                                    <el-table :data="row.inventory">
                                        <el-table-column property="description" label="Producto"
                                            width="260"></el-table-column>
                                        <el-table-column property="quantity" label="Cantidad"
                                            width="100"></el-table-column>
                                        <el-table-column label="Series" width="52" fixed="right">
                                            <template slot-scope="scope">
                                                <el-popover placement="right" width="350" trigger="click">
                                                    <el-table :data="scope.row.lots" width="300">
                                                        <el-table-column prop="series" label="Series"
                                                            width="300"></el-table-column>
                                                    </el-table>
                                                    <el-button slot="reference" icon="el-icon-zoom-in"></el-button>
                                                </el-popover>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <el-button slot="reference" icon="el-icon-zoom-in"></el-button>
                                </el-popover>
                            </td>
                            <td class="text-center">{{ row.quantity }}</td>
                            <!-- <td class="">
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                        @click.prevent="clickCreate(row.id)">Editar</button>
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDelete(row.id)">Eliminar</button>
                            </td> -->
                        </tr>
                    </data-table>
                </div>

                <inventories-form :showDialog.sync="showDialog" :recordId="recordId"
                    :isDirect="direct"></inventories-form>
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
            direct: false
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
