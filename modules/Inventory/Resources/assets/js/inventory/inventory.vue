<!-- Listado de Inventario  todo este modulo no esta en uso por que se uso para prueba-->

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
                        Listado de {{ title }}</h4>
                </div>
                <!-- <div class="data-table-visible-columns">
                        <el-button type="primary" 
                                    class="btn btn-success button-margin" 
                                    href="javascript:void(0)" 
                                    @click.prevent="clickCreate('input')">
                                    
                                <i class="fa fa-arrow-circle-down fa-lg"></i>
                               Ingreso
                        </el-button>
                </div> 
                <div class="data-table-visible-columns">
                        <el-button type="primary" 
                                    class="" 
                                    href="javascript:void(0)" 
                                    @click.prevent="clickOutput()">
                              <i class="fa fa-arrow-circle-up fa-lg"></i>
                                Salida
                        </el-button>
                </div> -->

                <div class="card-body">
                    <data-table :resource="resource" ref="dataTable">
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white text-center">#</th>
                            <th class="text-white text-left">Producto</th>
                            <th class="text-white text-left">Almacén</th>
                            <th class="text-white text-center">Stock</th>
                            <th class="text-white text-center">Stock real</th>
                        </tr>

                        <tr calss="text-white"></tr>
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
                                    <table class="table table-responsive table-striped">
                                        <thead>
                                            <tr slot="heading" class="bg-primary">
                                                <th class="text-white">SERIE</th>
                                                <th class="text-white">FECHA</th>
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
                                <template
                                    v-if="
                                        row.has_color_size &&
                                            row.color_size.length != 0
                                    "
                                >
                                    <table class="table table-responsive table-striped ">
                                        <thead>
                                            <tr slot="heading" class="bg-primary">
                                                <th class="text-white">COLOR</th>
                                                <th class="text-white">TALLA</th>
                                                <th class="text-white">PRECIO</th>
                                                <th class="text-white">STOCK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(color_size,
                                                idx) in row.color_size"
                                                :key="idx"
                                            >
                                                <td>
                                                    {{ color_size.color }}
                                                </td>
                                                <td>
                                                    {{ color_size.size }}
                                                </td>
                                                <td>
                                                    {{ color_size.price }}
                                                </td>
                                                <td>
                                                    {{ color_size.stock }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                        :disabled="row.series_enabled || row.has_color_size"
                                        size="mini"
                                        class="w-50"
                                        type="number"
                                        v-model="row.realStock"
                                        :min="1"
                                        :precision="2"
                                        @keypress="onlyAllowNumbers"
                                        controls-position="right"
                                        
                                    >
                                        <el-button
                                            :disabled="
                                                row.series_enabled ||
                                                    row.has_color_size
                                            "
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
            :type.sync="typeTransaction"
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

<style>
    .button-margin {
      margin-right: 100px; /* Ajusta este valor según sea necesario */
    }
  </style>

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
        onlyAllowNumbers(event) {
            const charCode = event.which ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        },
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
