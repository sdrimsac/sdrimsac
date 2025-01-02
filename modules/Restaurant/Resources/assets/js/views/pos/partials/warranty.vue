<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        title="Productos con Garantia"
        close-on-click-modal
        width="70%"
    >
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <label for="seller_id">Clientes</label>

                        <el-select
                            filterable
                            clearable
                            v-model="search.customer_id"
                            class="border-left rounded-left border-info w-100"
                            popper-class="el-select-customers"
                            placeholder="Seleccione o escriba el nombre del cliente para buscar"
                            @change="getWarrantyRecords"
                        >
                            <el-option
                                v-for="(option, idx) in customers"
                                :key="idx"
                                :value="option.id"
                                :label="option.name"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <label for="seller_id">Productos</label>

                        <el-select
                            filterable
                            clearable
                            v-model="search.item_id"
                            class="border-left rounded-left border-info w-100"
                            popper-class="el-select-customers"
                            placeholder="Seleccione un producto"
                            @change="getWarrantyRecords"
                        >
                            <el-option
                                v-for="(option, idx) in items"
                                :key="idx"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-4">
                        <label>Garantia</label>
                        <el-input></el-input>
                    </div>
                </div>
                <br />
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-white">N° DOCUMENTO</th>
                                    <th class="text-white">CLIENTE</th>
                                    <th class="text-white">PRODUCTO</th>
                                    <th class="text-white">SERIE</th>
                                    <th class="text-white">
                                        GARANTIA RESTANTE
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(row, index) in records"
                                    :row="row"
                                    :index="customIndex(index)"
                                >
                                    <td>{{ row.series }}-{{ row.number }}</td>
                                    <td>
                                        {{ row.customer.name }} <br />
                                        {{ row.customer.number }}
                                    </td>
                                    <td>{{ row.producto_descripcion }}</td>
                                    <td>
                                        {{
                                            row.serie !== "N/A"
                                                ? `N° serie: ${row.serie}`
                                                : ""
                                        }}
                                    </td>
                                    <!-- <td>{{ row.dias_restantes }} dias restantes</td> -->
                                    <td
                                        :style="{
                                            color:
                                                row.dias_restantes < 0
                                                    ? 'red'
                                                    : 'green'
                                        }"
                                    >
                                        {{
                                            row.dias_restantes < 0
                                                ? "Garantia finalizado"
                                                : `${row.dias_restantes} dias restantes`
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <el-pagination
                            @current-change="getWarrantyRecords"
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"
                        >
                        </el-pagination>
                    </div>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>
import queryString from "query-string";
export default {
    props: ["showDialog"],
    data() {
        return {
            resource: "warranty",
            records: [],
            warranty: [],
            pagination: {
                total: 0,
                per_page: 10,
                current_page: 1
            },
            search: {
                value: ""
            },
            items: [],
            customers: []
        };
    },
    created() {
        this.$http.get(`/warranty/tables`).then(response => {
            console.log(response);
            this.items = response.data.items;
            this.customers = response.data.customers;
            console.log(this.customers);
        });
    },
    methods: {
        open() {
            this.getWarrantyRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        async getWarrantyRecords(page = 1) {
            if (this.time) {
                clearTimeout(this.time);
            }

            this.time = setTimeout(async () => {
                try {
                    let url = `/${
                        this.resource
                    }/records2?${this.getQueryParameters()}`;
                    const response = await this.$http.get(url);

                    let data = response.data;

                    this.records = data.data.map(record => {
                        const producto =
                            record.producto_sale_note ??
                            record.producto_document;

                        // Valores predeterminados
                        const productoDescripcion =
                            producto?.description || "N/A";
                        const productoInternalId =
                            producto?.internal_id || "N/A";
                        const productoMonth = producto?.month_day || "N/A";

                        const item =
                            record.document_item?.item ||
                            record.sale_note_item?.item ||
                            record.document_customer?.item ||
                            record.sale_note_customer?.item ||
                            "N/A";

                        const customer = record.document_customer ||
                            record.sale_note_customer || {
                                id: "N/A",
                                name: "N/A",
                                number: "N/A"
                            };

                        const number = record.sale_note_number || record.document_number || "N/A";
                        const series = record.sale_note_series || record.document_series || "N/A";
                        const serie = producto?.lots?.length
                            ? producto.lots[0]?.series || "N/A"
                            : "N/A";

                        return {
                            ...record,
                            item,
                            customer: {
                                id: customer.id,
                                name: customer.name,
                                number: customer.number
                            },
                            producto_descripcion: productoDescripcion,
                            producto_internal_id: productoInternalId,
                            producto_month_day: productoMonth,
                            number,
                            series,
                            serie
                        };
                    });

                    // Configuración de la paginación
                    this.pagination = {
                        ...data.meta,
                        per_page: parseInt(data.meta.per_page)
                    };
                } catch (error) {
                    console.error("Error fetching warranty records:", error);
                }
            }, 500);
        },

        customIndex(index) {
            if (this.resource == "caja/cash-transfer/report") {
                return index + 1;
            }
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getQueryParameters() {
            if (this.search.value && typeof this.search.value == "object") {
                this.search.value = this.search.value.join(",");
            }
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                customer_id: this.search.customer_id,
                item_id: this.search.item_id
            });
        }
    }
};
</script>
