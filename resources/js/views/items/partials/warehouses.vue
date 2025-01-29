<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="open"
        append-to-body
        top="7vh"
        v-loading="loading"
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <el-tabs
                    tab-position="top"
                    type="card"
                    v-model="activeName"
                    @tab-click="getRecords"
                >
                    <el-tab-pane label="Stock de Producto" name="stock">
                        <div class="row">
                            <div class="col-md-12" v-if="warehouses && item">
                                <table class="table">
                                    <thead style="background-color: #1e5a85; color: white;">
                                      <tr>
                                        <th class="text-white">Almacén</th>
                                        <th class="text-white">Stock</th>
                                        <th  class="text-white"> Opciones</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(row, idx) in warehouses"
                                            :key="idx"
                                        >
                                            <th>
                                                {{ row.warehouse_description }}
                                            </th>
                                            <th>
                                                <template
                                                    v-if="item.max_quantity"
                                                >
                                                    {{
                                                        stockMaxQuantity(
                                                            row.stock,
                                                            item
                                                        )
                                                    }}
                                                </template>
                                                <template v-else>
                                                    <template
                                                        v-if="
                                                            config &&
                                                                config.college
                                                        "
                                                        >{{
                                                            parseInt(row.stock)
                                                        }}</template
                                                    >
                                                    <template v-else>{{
                                                        row.stock
                                                    }}</template>
                                                </template>
                                            </th>
                                            <th>
                                                <button
                                                    v-if="
                                                        !hasSerie &&
                                                            config &&
                                                            config.item_adjustment
                                                    "
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-warning"
                                                    @click.prevent="
                                                        clickStock(row)
                                                    "
                                                >
                                                    Ajuste de Stock
                                                    <el-tooltip
                                                        class="item"
                                                        content="Ajuste: stock del sistema no cuadre con el stock real"
                                                        effect="dark"
                                                        placement="top"
                                                    >
                                                        <i
                                                            class="fa fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </button>
                                                <!-- <button
                                                    v-if="
                                                        user.type ==
                                                            'superadmin'
                                                    "
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-warning"
                                                    @click.prevent="
                                                        clickStockRestoreKardex(
                                                            row.id
                                                        )
                                                    "
                                                >
                                                    <i class="fa fa-trash"></i>
                                                    <el-tooltip
                                                        class="item"
                                                        content="Elimina todo los registros del kardex e inserta la cantidad actual como stock inicial"
                                                        effect="dark"
                                                        placement="top"
                                                    >
                                                        <i
                                                            class="fa fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </button> -->
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td
                                                class=""
                                                template
                                                v-if="config && config.college"
                                            >
                                                {{ parseInt(total) }}
                                            </td>
                                            <td class="text-end" v-else>
                                                <template
                                                    v-if="
                                                        item &&
                                                            item.max_quantity
                                                    "
                                                    >{{
                                                        stockMaxQuantity(
                                                            total,
                                                            item
                                                        )
                                                    }}</template
                                                >
                                                <template v-else>{{
                                                    total.toFixed(2)
                                                }}</template>
                                            </td>
                                            <td> </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div v-if="hasSerie">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Total de series activas:
                                                </td>
                                                <td class="text-end">
                                                    <strong>{{
                                                        series
                                                    }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="unit_type.length > 0">
                                    <h6>Lista de Precios Creados</h6>
                                    <table class="table">
                                        <thead style="background-color: #1e5a85; color: white; text-align: center;">
                                          <tr>
                                            <th>Unidad</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Total</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="row in unit_type"
                                                :key="row.id"
                                            >
                                                <th>{{ row.unit_type_id }}</th>
                                                <th>{{ row.description }}</th>
                                                <th>{{ row.quantity_unit }}</th>
                                                <th>{{ row.price2 }}</th>
                                                <th>
                                                    {{
                                                        
                                                    row.total
                                                    }}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Ultimas Ventas" name="sales_">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead style="background-color: #1e5a85; color: white;">
                                      <tr>
                                        <th class="text-center text-white">#</th>
                                        <th class="text-white">Fecha</th>
                                        <th class="text-center text-white">
                                          Documento
                                        </th>
                                        <th class="text-center text-white">Cliente</th>
                                        <th class="text-center text-white">
                                          Cantidad
                                        </th>
                                        <th class="text-end text-white">Precio</th>
                                        <th class="text-end text-white">Total</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(sale, index) in sales"
                                            :key="index"
                                        >
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
                    <el-tab-pane label="Ultimas Compras" name="purchases_">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead style="background-color: #1e5a85; color: white;">
                                      <tr>
                                        <th class="text-white">#</th>
                                        <th class="text-center text-white">Fecha</th>
                                        <th class="text-center text-white">Documento</th>
                                        <th class="text-center text-white">Proveedor</th>
                                        <th class="text-center text-white">Cantidad</th>
                                        <th class="text-end text-white">Precio</th>
                                        <th class="text-end text-white">Total</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(purchase,
                                            index) in purchases"
                                            :key="index"
                                        >
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
                                            <td class="text-center">
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
                    <!-- <el-tab-pane label="Ajustar stock almacén" name="stock_warehouse"
                    v-if="user.type == 'superadmin'"
                    >
                        <div class="row">
                            <div class="col-md-12" v-if="warehouses && item">
                                <table class="table">
                                    <thead style="background-color: #1e5a85; color: white;">
                                      <tr>
                                        <th class="text-white">Almacén</th>
                                        <th class="text-white">Stock</th>
                                        <th  class="text-white"> Opciones</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(row, idx) in warehouses"
                                            :key="idx"
                                        >
                                            <th>
                                                {{ row.warehouse_description }}
                                            </th>
                                            <th>
                                                <template
                                                    v-if="item.max_quantity"
                                                >
                                                    {{
                                                        stockMaxQuantity(
                                                            row.stock,
                                                            item
                                                        )
                                                    }}
                                                </template>
                                                <template v-else>
                                                    <template
                                                        v-if="
                                                            config &&
                                                                config.college
                                                        "
                                                        >{{
                                                            parseInt(row.stock)
                                                        }}</template
                                                    >
                                                    <template v-else>{{
                                                        row.stock
                                                    }}</template>
                                                </template>
                                            </th>
                                            <th>
                                                <button
                                                    v-if="
                                                        !hasSerie &&
                                                            config &&
                                                            config.item_adjustment
                                                    "
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-warning"
                                                    @click.prevent="
                                                        clickStock(row)
                                                    "
                                                >
                                                    Ajuste de Stock
                                                    <el-tooltip
                                                        class="item"
                                                        content="Ajuste: stock del sistema no cuadre con el stock real"
                                                        effect="dark"
                                                        placement="top"
                                                    >
                                                        <i
                                                            class="fa fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </button>
                                            
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td
                                                class=""
                                                template
                                                v-if="config && config.college"
                                            >
                                                {{ parseInt(total) }}
                                            </td>
                                            <td class="text-end" v-else>
                                                <template
                                                    v-if="
                                                        item &&
                                                            item.max_quantity
                                                    "
                                                    >{{
                                                        stockMaxQuantity(
                                                            total,
                                                            item
                                                        )
                                                    }}</template
                                                >
                                                <template v-else>{{
                                                    total.toFixed(2)
                                                }}</template>
                                            </td>
                                            <td> </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div v-if="hasSerie">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Total de series activas:
                                                </td>
                                                <td class="text-end">
                                                    <strong>{{
                                                        series
                                                    }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="unit_type.length > 0">
                                    <h6>Lista de Precios Creados</h6>
                                    <table class="table">
                                        <thead style="background-color: #1e5a85; color: white; text-align: center;">
                                          <tr>
                                            <th>Unidad</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Total</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="row in unit_type"
                                                :key="row.id"
                                            >
                                                <th>{{ row.unit_type_id }}</th>
                                                <th>{{ row.description }}</th>
                                                <th>{{ row.quantity_unit }}</th>
                                                <th>{{ row.price2 }}</th>
                                                <th>
                                                    {{
                                                        (
                                                            Number(row.price2) *
                                                            Number(
                                                                row.quantity_unit
                                                            )
                                                        ).toFixed(2)
                                                    }}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane> -->
                    <div
                        class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
                    >
                        <el-button
                            class="btn-cancel btn-cancel:hover"
                            @click.prevent="close()"
                        >
                            <i class="fas fa-times fa-lg"></i> &nbsp;
                            Cancelar</el-button
                        >
                    </div>
                </el-tabs>
            </div>
            <div></div>
        </form>

        <inventories-stock
            :user="user"
            :showDialog.sync="showDialogStock"
            :recordId="recordId"
            :config="config"
        ></inventories-stock>
    </el-dialog>
</template>

<script>
import InventoriesStock from "./stock.vue";

export default {
    components: {
        InventoriesStock
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
        "fromPos"
    ],
    data() {
        return {
            previousItemId: null,
            showDialogStock: false,
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
