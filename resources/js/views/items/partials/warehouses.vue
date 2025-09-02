<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="open" append-to-body top="7vh"
        v-loading="loading" :close-on-click-modal="false">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <el-tabs tab-position="top" type="card" v-model="activeName" @tab-click="getRecords">
                    <el-tab-pane label="Stock de Producto" name="stock">
                        <div class="row">
                            <div class="col-md-12" v-if="warehouses && item">
                                <table class="table">
                                    <thead style="background-color: #1e5a85; color: white;">
                                        <tr>
                                            <th class="text-white" style="width: 40%; padding: 4px;">Almacén</th>
                                            <th class="text-white" style="width: 30%; padding: 4px;">Stock</th>
                                            <th class="text-white" style="width: 30%; padding: 4px;">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, idx) in warehouses" :key="idx">
                                            <td>
                                                {{ row.warehouse_description }}
                                            </td>
                                            <td>
                                                <template v-if="item.max_quantity">
                                                    {{
                                                        stockMaxQuantity(
                                                            row.stock,
                                                            item
                                                        )
                                                    }}
                                                </template>
                                                <template v-else>
                                                    <template v-if="config && config.college">{{
                                                        parseInt(row.stock)
                                                    }}</template>
                                                    <template v-else>{{
                                                        row.stock
                                                    }}</template>
                                                </template>
                                            </td>
                                            <td>
                                                <el-button :type="row.active ? 'success' : 'danger'">
                                                    {{
                                                        row.active
                                                            ? "Activo"
                                                            : "Inhabilitado"
                                                    }}
                                                </el-button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="padding:0; margin:0;">
                                                <hr style="margin:0; padding:0;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%; font-size: 1.2em;">Total</td>
                                            <td class="" v-if="config && config.college">
                                                {{ parseInt(total) }}
                                            </td>
                                            <td style="width: 30%;" class="text-left" v-else>
                                                <template v-if="item && item.max_quantity">{{
                                                    stockMaxQuantity(
                                                        total,
                                                        item
                                                    )
                                                }}</template>
                                                <template v-else>{{
                                                    total.toFixed(2)
                                                }}</template>
                                            </td>
                                            <td style="width: 30%;"></td>
                                        </tr>
                                         <tr>
                                            <td colspan="3" style="padding:0; margin:0;">
                                                <hr style="margin:0; padding:0;" />
                                            </td>
                                        </tr>
                                        <tr v-if="hasSerie">
                                            <td colspan="3" style="padding: 0px;">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 40%;">
                                                                Total de series activas:
                                                            </td>
                                                            <td style="width: 30%;" class="text-left">
                                                                <strong>{{
                                                                    series
                                                                }}</strong>
                                                            </td>
                                                            <td style="width: 30%;">
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                                <div v-if="unit_type.length > 0">
                                    <h4><strong>Políticas de Precio</strong></h4>
                                    <table class="table">
                                        <thead style="background-color: #1e5a85; color: white; text-align: center;">
                                            <tr>
                                                <th class="text-white text-center" style="width: 10%; padding: 4px;">Unidad</th>
                                                <th class="text-white text-center" style="width: 35%; padding: 4px;">Descripción</th>
                                                <th class="text-white text-center" style="width: 15%; padding: 4px;">Cantidad</th>
                                                <th class="text-white text-center" style="width: 15%; padding: 4px;">Precio</th>
                                                <!-- <th class="text-white text-center" style="width: 20%;">Total</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="row in unit_type" :key="row.id">
                                                <td class="text-center">{{ row.unit_type_id }}</td>
                                                <td class="text-center">{{ row.description }}</td>
                                                <td class="text-center">{{ parseFloat(row.quantity_unit).toFixed(2) }}</td>
                                                <td class="text-center">{{ row.price2 }}</td>
                                                <!-- <td class="text-center">{{ row.total }}</td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Últimas Ventas" name="sales_">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead style="background-color: #1e5a85; color: white;">
                                        <tr>
                                            <th class="text-center text-white">
                                                #
                                            </th>
                                            <th class="text-white">Fecha</th>
                                            <th class="text-center text-white">
                                                Documento
                                            </th>
                                            <th class="text-center text-white">
                                                Cliente
                                            </th>
                                            <th class="text-center text-white">
                                                Cantidad
                                            </th>
                                            <th class="text-end text-white">
                                                Precio
                                            </th>
                                            <th class="text-end text-white">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(sale, index) in sales" :key="index">
                                            <td>{{ customIndex(index) }}</td>
                                            <td>{{ sale.date_of_issue }}</td>
                                            <td class="text-center">
                                                {{ sale.series }}-{{
                                                    sale.number
                                                }}
                                            </td>
                                            <td class="text-center">
                                                {{ sale.customer_name }}
                                                <br />
                                                {{ sale.customer_number }}
                                            </td>
                                            <td class="text-center">
                                                {{
                                                    parseFloat(
                                                        sale.quantity
                                                    ).toFixed(2)
                                                }}
                                            </td>
                                            <td class="text-end">
                                                {{
                                                    parseFloat(
                                                        sale.unit_value
                                                    ).toFixed(2)
                                                }}
                                            </td>
                                            <td class="text-end">
                                                {{ sale.total }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Últimas Compras" name="purchases_">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead style="background-color: #1e5a85; color: white;">
                                        <tr>
                                            <th class="text-white">#</th>
                                            <th class="text-center text-white">
                                                Fecha
                                            </th>
                                            <th class="text-center text-white">
                                                Documento
                                            </th>
                                            <th class="text-center text-white">
                                                Proveedor
                                            </th>
                                            <th class="text-center text-white">
                                                Cantidad
                                            </th>
                                            <th class="text-end text-white">
                                                Precio
                                            </th>
                                            <th class="text-end text-white">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(purchase,
                                            index) in purchases" :key="index">
                                            <td>
                                                {{
                                                    customIndex(
                                                        index,
                                                        "purchases_"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                {{ purchase.date_of_issue }}
                                            </td>
                                            <td class="text-center">
                                                {{ purchase.series }}-{{
                                                    purchase.number
                                                }}
                                            </td>
                                            <td class="text-left" style="text-align: left;">
                                                {{ purchase.supplier_name }}
                                                <br />
                                                {{ purchase.supplier_number }}
                                            </td>
                                            <td class="text-center">
                                                {{
                                                    parseFloat(
                                                        purchase.quantity
                                                    ).toFixed(2)
                                                }}
                                            </td>
                                            <td class="text-center">
                                                {{
                                                    parseFloat(
                                                        purchase.unit_value
                                                    ).toFixed(2)
                                                }}
                                            </td>
                                            <td class="text-end">
                                                {{ purchase.total }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </el-tab-pane>
                    <div class="d-flex justify-content-end" style="padding: 8px;">
                        <el-button class="btn_cancelarsmall" @click.prevent="close()">
                            <i class="fas fa-times fa-lg"></i> &nbsp;
                            Cerrar
                        </el-button>
                    </div>

                </el-tabs>
            </div>
            <div></div>
        </form>

        <inventories-stock :user="user" :showDialog.sync="showDialogStock" :recordId="recordId"
            :config="config"></inventories-stock>
        <series-list-dialog :visible.sync="showDialogSeries" :series="seriesList" @close="showDialogSeries = false" />
    </el-dialog>
</template>

<script>
import InventoriesStock from "./stock.vue";

import SeriesListDialog from "./SeriesListDialog.vue";

export default {
    components: {
        InventoriesStock,
        SeriesListDialog
    },
    props: [
        "allWarehouses",
        "user",
        "showDialog",
        "warehouses",
        "unit_type",
        "itemId",
        "hasSerie",
        "item",
        "config",
        "record",
        "fromPos",
        "active"
    ],
    data() {
        return {
            previousItemId: null,
            showDialogStock: false,
            showDialogSeries: false,
            seriesList: [],
            showImportDialog: false,
            resource: "items",
            total: 0,
            recordId: null,
            titleDialog: "Stock de producto",
            series: null,
            loading: false,
            maxDescription: "",
            ventas: "stock",
            sales: [],
            purchases: [],
            activeName: "stock",
            pagination: {
                sales: {
                    current_page: 1
                },
                purchases: {
                    current_page: 1
                }
            }
        };
    },
        async showSeriesDialog(record) {
            this.loading = true;
            try {
                // Cambia la URL si necesitas filtrar por almacén o producto
                const response = await this.$http.get(`/documents/get-series/${record.id}`);
                this.seriesList = Array.isArray(response.data) ? response.data : [];
                this.showDialogSeries = true;
            } catch (e) {
                this.$toast && this.$toast.error("No se pudieron obtener las series.");
            } finally {
                this.loading = false;
            }
        },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.close();
        });
        if (this.fromPos) {
            this.open();
        }
    },
    mounted() {
        console.log(this.user);
    },
    methods: {
        async clickStockRestoreKardex(item_warehouse_id) {
            // console.log("🚀 ~ clickStockRestoreKardex ~ warehouse_id:", warehouse_id)
            // return;
            try {
                this.$confirm(
                    "¿Está seguro de realizar esta acción?",
                    "Advertencia",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                )
                    .then(async () => {
                        this.loading = true;
                        const response = await this.$http.get(
                            `/items/restore-kardex/${item_warehouse_id}`
                        );
                        this.$toast.success(response.data.message);
                        this.getRecords();
                    })
                    .catch(() => {
                        this.$toast.info("Operación cancelada");
                    });
            } catch (e) {
                console.log(e);
                const {
                    response: {
                        data: { message }
                    }
                } = e;
                this.$toast.error(message);
            } finally {
                this.loading = false;
            }
        },
        customIndex(index, type = "sales_") {
            //2
            //5 * (1 - 1) + 0 + 1 = 5 * (0) + 0 + 1 = 1
            //5 * (2 -1) +2 + 1 = 8
            let per_page =
                type == "sales_"
                    ? this.pagination.sales.per_page
                    : this.pagination.purchases.per_page;
            let current_page =
                type == "sales_"
                    ? this.pagination.sales.current_page
                    : this.pagination.purchases.current_page;

            return per_page * (current_page - 1) + index + 1;
        },
        async getRecords(page = 1) {
            this.loading = true;
            console.log("ac: ", this.activeName);
            if (this.activeName == "sales_") {
                this.pagination.sales.current_page = parseInt(page);
                await this.getsales(page);
            } else {
                this.pagination.purchases.current_page = parseInt(page);
                await this.getpurchases(page);
            }

            this.loading = false;
        },

        async getsales(page = 1) {
            if (!this.itemId) {
                /* this.itemlocal = this.itemId; */
                console.log("Item ID vacio");
                return;
            }
            try {
                const response = await this.$http.get(
                    `/items/ultima-venta/${this.itemId}?page=${page}`
                );
                this.sales = response.data.data;
                this.pagination.sales = response.data.meta;
                /* let { item_description } = data; */
                /* this.titleDialog = `Habitación ${item_description}`; */
                this.pagination.sale.per_page = parseInt(
                    response.data.meta.per_page
                );

                // this.$emit("getRecords", this.pagination.sales.current_page);
            } catch (e) {
                console.log(e);
            } finally {
                this.isRequesting = false;
            }
        },
        async getpurchases(page = 1) {
            if (!this.itemId) {
                /* this.itemlocal = this.itemId; */
                console.log("Item ID vacio en compra");
                return;
            }
            try {
                const response = await this.$http.get(
                    `/items/ultima-compra/${this.itemId}?page=${page}&date_of_issue=2024-05-09`
                );
                this.purchases = response.data.data;
                this.pagination.purchases = response.data.meta;
                this.pagination.purchases.per_page = parseInt(
                    response.data.meta.per_page
                );
            } catch (e) {
                console.log(e);
            } finally {
                this.isRequesting = false;
            }
        },

        stockMaxQuantity(stock = 0, item) {
            let {
                max_quantity,
                unit_type_description,
                max_quantity_description
            } = item;
            stock = Number(stock);
            let general = Math.trunc(stock / max_quantity);
            let part = (stock / max_quantity) % 1;
            let text = `${general} ${max_quantity_description}`;
            if (part != 0) {
                let new_part = part * max_quantity;
                new_part = new_part.toFixed(2);
                if (general > 0) {
                    text += ` ${new_part} ${unit_type_description}`;
                } else {
                    text = `${new_part} ${unit_type_description}`;
                }
            }

            return text;
        },
        clickStock(record) {
            this.recordId = record.id;
            this.showDialogStock = true;
        },
        open() {
            this.total = this.warehouses.reduce(
                (a, b) => a + Number(b.stock),
                0
            );
            this.titleDialog = `Stock de producto: ${this.item.description} ${this.item.internal_id}`;
            if (this.hasSerie) {
                this.getSeries();
            }
            console.log(this.warehouses);
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async getSeries() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/documents/get-series/${this.itemId}`
                );
                this.series = response.data;
            } catch (e) {
                console.log(e);
                const {
                    response: {
                        data: { message }
                    }
                } = e;
                this.$toast.error(message);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
