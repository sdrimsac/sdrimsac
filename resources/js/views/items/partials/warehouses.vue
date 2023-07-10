<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="open"
        append-to-body
        top="7vh"
        v-loading="loading"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12" v-if="warehouses && item">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ubicación</th>
                                    <th class="text-end">Stock</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, idx) in warehouses" :key="idx">
                                    <th>{{ row.warehouse_description }}</th>
                                    <th class="text-end">
                                        <template v-if="item.max_quantity">
                                            {{
                                                stockMaxQuantity(row.stock,item)
                                                
                                            }}
                                        </template>
                                        <template v-else>
                                            <template
                                                v-if="config && config.college"
                                            >
                                                {{ parseInt(row.stock) }}
                                            </template>
                                            <template v-else>
                                                {{ row.stock }}
                                            </template>
                                        </template>
                                    </th>
                                    <th>
                                        <button
                                            v-if="!hasSerie"
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-warning"
                                            @click.prevent="clickStock(row)"
                                        >
                                            Ajuste
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
                                    <td>
                                        Total
                                    </td>
                                    <td
                                        class="text-end"
                                        template
                                        v-if="config && config.college"
                                    >
                                        {{ parseInt(total) }}
                                    </td>
                                    <td class="text-end"  v-else>
                                        <template v-if="item && item.max_quantity">
                                        {{ stockMaxQuantity(total,item) }}
                                        </template>
                                        <template v-else>
                                        {{ total.toFixed(2) }}
                                        </template>
                                    </td>
                                    <td></td>
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
                                            <strong>
                                                {{ series }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="unit_type.length > 0">
                            <h6>Lista de Precios Creados</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Unidad</th>
                                        <th>Description</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="row in unit_type" :key="row.id">
                                        <th>{{ row.unit_type_id }}</th>
                                        <th>{{ row.description }}</th>
                                        <th>{{ row.quantity_unit }}</th>
                                        <th>{{ row.price2 }}</th>
                                        <th>
                                            {{
                                                Number(row.price2) *
                                                    Number(row.quantity_unit)
                                            }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cerrar</el-button>
            </div>
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
    components: { InventoriesStock },
    props: [
        "user",
        "showDialog",
        "warehouses",
        "unit_type",
        "itemId",
        "hasSerie",
        "item",
        "config"
    ],
    data() {
        return {
            showDialogStock: false,

            showImportDialog: false,
            resource: "items",
            total: 0,
            recordId: null,
            titleDialog: "Stock de producto",
            series: null,
            loading: false,
            maxDescription: ""
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.close();
        });

        //console.log(this.typeUser)
    },
    methods: {
        stockMaxQuantity(stock = 0, item) {
            let {
                max_quantity,
                unit_type_description,
                max_quantity_description,
            } = item;
                stock = Number(stock);
                let general = Math.trunc(stock / max_quantity);
                let part = (stock / max_quantity) % 1;
                let text = `${general} ${max_quantity_description}`;
                if (part != 0) {
                    let new_part = part * max_quantity;
                    new_part = new_part.toFixed(2);
                    text += ` ${new_part} ${unit_type_description}`;
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
        
            if (this.hasSerie) {
                this.getSeries();
            }
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
