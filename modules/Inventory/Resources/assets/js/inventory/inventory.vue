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
            </div>
        </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-clipboard-list"></i>
                    <i class="fas fa-truck-loading"></i>
                    Listado de {{ title }}
                </h4>
            </div>
            <div
            v-if="typeUser == 'superadmin'"
             class="data-table-visible-columns">
                <el-button type="primary" @click="openModal">
                    <i class="fas fa-box fa-lg"></i>
                    Regularizar Stock de Productos
                </el-button>

                <el-button type="primary" @click="resetKardex">
                    <i class="fas fa-trash fa-lg"></i>
                    Regularización de kardex
                </el-button>
            </div>
            <div class="card-body" v-loading="loading">
                <data-table :resource="resource" ref="dataTable">
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white text-center">#</th>
                        <th class="text-white text-left">Producto</th>
                        <th class="text-white text-left">Almacén</th>
                        <th class="text-white text-center">Stock</th>
                        <th class="text-white text-center"
                        v-if="typeUser == 'superadmin'"
                        >Stock real</th>
                    </tr>
                    <tr slot-scope="{ index, row }">
                        <td class="text-center">{{ index }}</td>
                        <td class="text-left">
                            {{ row.item_fulldescription }}
                            <template v-if="row.series_enabled && row.series.length">
                                <table class="table table-responsive table-striped">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th class="text-white">SERIE</th>
                                            <th class="text-white">FECHA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(serie, idx) in row.series" :key="idx">
                                            <td>{{ serie.series }}</td>
                                            <td>{{ serie.date }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-if="row.has_color_size && row.color_size.length">
                                <table class="table table-responsive table-striped">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th class="text-white">COLOR</th>
                                            <th class="text-white">TALLA</th>
                                            <th class="text-white">PRECIO</th>
                                            <th class="text-white">STOCK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(color_size, idx) in row.color_size" :key="idx">
                                            <td>{{ color_size.color }}</td>
                                            <td>{{ color_size.size }}</td>
                                            <td>{{ color_size.price }}</td>
                                            <td>{{ color_size.stock }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                        </td>
                        <td class="text-left">{{ row.warehouse_description }}</td>
                        <td class="text-center">{{ parseFloat(row.stock).toFixed(2) }}</td>
                        <td class="text-center"
                        v-if="typeUser == 'superadmin'"
                        >
                            <div class="flex">
                                <el-input :disabled="row.series_enabled || row.has_color_size" size="mini" class="w-50" type="number" v-model="row.realStock" :min="1" :precision="2" @keypress="onlyAllowNumbers" controls-position="right">
                                    <el-button :disabled="row.series_enabled || row.has_color_size" @click="clickSetStockReal(row.item_id, row.realStock, row.stock, row.warehouse_id)" slot="append" icon="el-icon-top-right"></el-button>
                                </el-input>
                            </div>
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
    <inventories-almacen :showDialog.sync="showDialogAlmacen" :warehouses.sync="warehouses" @regularizarStock="handleRegularizarStock"></inventories-almacen>
</div>
</template>

  
<script>
import DataTable from "../../../assets/components/DataTableValuedInventory";
import InventoriesForm from "./form.vue";
import InventoriesFormOutput from "./form_output.vue";
import InventoriesMove from "./move.vue";
import InventoriesRemove from "./remove.vue";
import InventoriesAlmacen from "./partials/almacen.vue";

export default {
    props: ["type", "typeUser"],
    components: {
        DataTable,
        InventoriesForm,
        InventoriesFormOutput,
        InventoriesMove,
        InventoriesRemove,
        InventoriesAlmacen
    },
    data() {
        return {
            title: "Inventario",
            showDialog: false,
            showDialogMove: false,
            showDialogRemove: false,
            showDialogOutput: false,
            showDialogAlmacen: false,
            resource: "reports/inventory",
            recordId: null,
            isModalVisible: false,
            loading:false,
            typeTransaction: null,
            warehouses: []
        };
        
    },
async mounted() {
        await this.$http.get(`/${this.resource}/tables`)
            .then(response => {
                this.warehouses = response.data.warehouses;
                this.categories = response.data.categories;
                this.items = response.data.items;
            });
    /* 
        await this.getRecords()*/
    }, 
    methods: {
        resetKardex(){
            this.$confirm('¿Estás seguro de querer resetear el kardex?', 'Advertencia', {
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                type: 'warning'
            }).then(() => {
                this.loading = true;
                this.$http.post(`/inventory/resetKardex`)
                    .then(response => {
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
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: 'Operación interrumpida'
                        });
                    }).finally(() => {
                        this.loading = false;
                    });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Operación cancelada'
                });
            }).finally(() => {
            });
        },
        openModal() {
            console.log("Opening modal, warehouses:", this.warehouses);
            this.showDialogAlmacen = true;
        },
        onlyAllowNumbers(event) {
            const charCode = event.which ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        },
        async clickSetStockReal(itemId, realStock, stock, warehouse_id) {
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
        },
        async handleRegularizarStock(warehouse_id) {
            this.showDialogAlmacen = false;

            if (!warehouse_id) {
                this.$message({
                    type: 'error',
                    message: 'Por favor, selecciona un almacén'
                });
                return;
            }

            const response = await this.$http.post(`/inventory/regularizarStock`, {
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
        }
    }
};
</script>
