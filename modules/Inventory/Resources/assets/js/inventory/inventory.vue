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
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">{{ title }}</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-6 text-end">
                        <button
                            type="button"
                            class="btn btn-success"
                            @click.prevent="clickCreate('input')"
                        >
                            Ingreso
                        </button>
                        <button
                            type="button"
                            class="btn btn-success"
                            @click.prevent="clickOutput()"
                        >
                            Salida
                        </button>
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
                    <data-table :resource="resource" ref="dataTable">
                        <tr slot="heading">
                            <th class="text-center">#</th>
                            <th class="text-left">Producto</th>
                            <th class="text-left">Almacén</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Stock real</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td class="text-center">{{ index }}</td>
                            <td class="text-left">
                                {{ row.item_fulldescription }}
                                <template
                                    v-if="
                                        row.series_enabled &&
                                            row.series.length != 0
                                    "
                                >
                                    <table class="table table-responsive ">
                                        <thead>
                                            <tr>
                                                <th>
                                                    SERIE
                                                </th>
                                                <th>
                                                    FECHA
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(serie,
                                                idx) in row.series"
                                                :key="idx"
                                            >
                                                <td>
                                                    {{ serie.series }}
                                                </td>
                                                <td>
                                                    {{ serie.date }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- <small>SERIES: </small>
                                    <span v-for="(serie,idx) in row.series" :key="idx">
                                        {{idx == 0 ? '':'-'}} 
                                        <small
                                        style="font-weight: bold;"
                                        >{{serie.series}}</small> 
                                    </span> -->
                                </template>
                            </td>
                            <td class="text-left">
                                {{ row.warehouse_description }}
                            </td>
                            <td class="text-center">
                                {{ parseFloat(row.stock).toFixed(2) }}
                            </td>
                            <td class="text-center">
                                <div class="flex">
                                    <el-input
                                        size="mini"
                                        class="w-50"
                                        type="number"
                                        v-model="row.realStock"
                                    >
                                        <el-button
                                            @click="
                                                clickSetStockReal(
                                                    row.item_id,
                                                    row.realStock,
                                                    row.stock,
                                                    row.warehouse_id
                                                )
                                            "
                                            slot="append"
                                            icon="el-icon-top-right"
                                        ></el-button>
                                    </el-input>
                                </div>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
        <inventories-form
            :showDialog.sync="showDialog"
            :type="typeTransaction"
        ></inventories-form>

        <inventories-form-output
            :showDialog.sync="showDialogOutput"
        ></inventories-form-output>

        <inventories-move
            :showDialog.sync="showDialogMove"
            :recordId="recordId"
        ></inventories-move>
        <inventories-remove
            :showDialog.sync="showDialogRemove"
            :recordId="recordId"
        ></inventories-remove>
    </div>
</template>

<script>
import DataTable from "../../../assets/components/DataTableValuedInventory";
import InventoriesForm from "./form.vue";
import InventoriesFormOutput from "./form_output.vue";
import InventoriesMove from "./move.vue";
import InventoriesRemove from "./remove.vue";
export default {
    props: ["type", "typeUser"],
    components: {
        DataTable,
        InventoriesForm,
        InventoriesMove,
        InventoriesRemove,
        InventoriesFormOutput
    },
    data() {
        return {
            title: null,
            showDialog: false,
            showDialogMove: false,
            showDialogRemove: false,
            showDialogOutput: false,
            resource: "reports/inventory",
            recordId: null,
            typeTransaction: null
        };
    },
    created() {
        this.title = "Inventario";
    },
    methods: {
        async clickSetStockReal(itemId, realStock, stock, warehouse_id) {
            //inventory/stock

            const response = await this.$http.post(`/inventory/stock`, {
                item_id: itemId,
                quantity_real: realStock,
                quantity: stock,
                warehouse_id: warehouse_id
            });
            if (response.data.success) {
                this.$message({
                    type: "success",
                    message: response.data.message
                });
                this.$refs.dataTable.getRecords();
            } else {
                this.$message({
                    type: "error",
                    message: response.data.message
                });
            }
            console.log(response);
        },
        clickMove(recordId) {
            this.recordId = recordId;
            this.showDialogMove = true;
        },
        clickCreate(type) {
            this.recordId = null;
            this.typeTransaction = type;
            this.showDialog = true;
        },
        clickRemove(recordId) {
            this.recordId = recordId;
            this.showDialogRemove = true;
        },
        clickOutput() {
            this.recordId = null;
            this.showDialogOutput = true;
        }
    }
};
</script>
