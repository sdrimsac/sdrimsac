<!-- Listado de Inventario -->
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
                <!-- <div class="col-6 text-end">
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
                    </div> -->
            </div>
        </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-clipboard-list"></i>
                    <i class="fas fa-truck-loading"></i>
                    Listado de Ingreso y Salida de Productos</h4>
            </div>
            <div class="data-table-visible-columns">
                <el-button type="primary" class="btn btn-success button-margin" href="javascript:void(0)" @click.prevent="clickCreate('input')">

                    <i class="fa fa-arrow-circle-down fa-lg"></i>
                    Ingreso
                </el-button>
            </div>
            <div class="data-table-visible-columns">
                <el-button type="primary" class="" href="javascript:void(0)" @click.prevent="clickOutput()">
                    <i class="fa fa-arrow-circle-up fa-lg"></i>
                    Salida
                </el-button>
            </div>

            <div class="card-body">
                <data-table :resource="resource" ref="dataTable">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white text-center">#</th>
                        <th class="text-white text-center">Codigo Interno</th>
                        <th class="text-white text-left">Producto</th>
                        <th class="text-white text-left">Almacén</th>
                        <th class="text-white text-left">Stock Movimiento</th>
                        <th class="text-white text-letf">Fecha Movimiento</th>
                        <th class="text-white text-center">Estado de Productos</th>
                    </tr>

                    <tr calss="text-white"></tr>

                    <tr slot-scope="{ index, row }">
                        <td class="text-center">{{ index }}</td>
                        <td class="text-center">{{ row.item_internal_id }}</td>
                        <td class="text-left">
                            {{ row.item_description }} <br> 
                           <span>{{  row.lot_code }}</span>
                            <template v-if="row.lots && row.lots.length > 0">
                                <table class="table table-responsive table-striped">
                                    <thead>
                                        <tr slot="heading" class="bg-primary">
                                            <!-- <th class="text-white">N°</th> -->
                                            <th class="text-white">SERIE </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="lots in row.lots" :key="lots.series">
                                            <td>
                                                {{ lots.series }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-if="
                                        row.color_size &&
                                            row.color_size.length != 0
                                    ">
                                <table class="table table-responsive table-striped ">
                                    <thead>
                                        <tr slot="heading" class="bg-primary">
                                            <th class="text-white">COLOR</th>
                                            <th class="text-white">TALLA</th>
                                            <th class="text-white">PRECIO</th>
                                            <!-- <th class="text-white">STOCK</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="color_size in row.color_size" :key="color_size.id">
                                            <td>
                                                {{ color_size.color }}
                                            </td>
                                            <td>
                                                {{ color_size.size }}
                                            </td>
                                            <td>
                                                {{ color_size.price }}
                                            </td>
                                            <!-- <td>
                                                {{ color_size.stock }}
                                            </td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                        </td>
                        <td class="text-left">
                            {{ row.warehouse_description }}
                        </td>
                        <td class="text-left">
                            {{ parseFloat(row.quantity).toFixed(2) }}
                        </td>
                        <td class="text_left">
                            {{ row.created_at }}
                        </td>
                        <td class="text_end">
                            <span :class="{'bg-success text-white rounded-pill px-2 py-1': row.type === 'input', 'bg-danger text-white rounded-pill px-2 py-1': row.type === 'output'}">
                                {{ row.type === 'input' ? 'ingreso' : 'salida' }}
                            </span>
                        </td>
                    </tr>
                </data-table>
            </div>
        </div>
    </div>
    <inventories-form :showDialog.sync="showDialog" :type.sync="typeTransaction"></inventories-form>

    <inventories-form-output :showDialog.sync="showDialogOutput"></inventories-form-output>

    <inventories-move :showDialog.sync="showDialogMove" :recordId="recordId"></inventories-move>
    <inventories-remove :showDialog.sync="showDialogRemove" :recordId="recordId"></inventories-remove>
</div>
</template>

<style>
.button-margin {
    margin-right: 100px;
    /* Ajusta este valor según sea necesario */
}
</style>

<script>
import DataTable from "../../../../modules/Inventory/Resources/assets/components/DataTableTransaction.vue";
import InventoriesForm from "../../../../modules/Inventory/Resources/assets/js/inventory/form.vue";
import InventoriesFormOutput from "../../../../modules/Inventory/Resources/assets/js/inventory/form_output.vue";
import InventoriesMove from "../../../../modules/Inventory/Resources/assets/js/inventory/move.vue";
import InventoriesRemove from "../../../../modules/Inventory/Resources/assets/js/inventory/remove.vue";
export default {
    props: [],
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
            resource: "productos",
            recordId: null,
            typeTransaction: null
        };
    },
    created() {
        this.title = "Productos";
        console.log("ddsadasd")
    },
    mounted() {
        console.log("dsadasd2")
    },
    methods: {
        onlyAllowNumbers(event) {
            const charCode = event.which ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        },
        async clickSetStockReal(itemId, realStock, stock, warehouse_id) {
            //inventory/stock

            const response = await this.$http.post(`/productos/stock`, {
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
            console.log("🚀 ~ clickCreate ~ type:", type)
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
