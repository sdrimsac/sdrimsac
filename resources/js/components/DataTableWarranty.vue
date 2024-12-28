<template>
    <div>
        <div class="row ">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row" v-if="applyFilter">
                    <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                        <label style="width:100%">
                            Filtrar por:
                        </label>
                        <el-select
                            v-model="search.column"
                            placeholder="Select"
                            @change="changeClearInput"
                        >
                            <el-option
                                v-for="(label, key) in columns"
                                :key="key"
                                :value="key"
                                :label="label"
                                clearable
                            ></el-option>
                        </el-select>
                    </div>
                    <!-- <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                        <label for="value">
                            Buscar
                        </label>

                        <template>
                            <el-input
                                placeholder="Buscar"
                                v-model="search.value"
                                style="width: 100%;"
                                prefix-icon="el-icon-search"
                                @input="getRecords"
                            >
                            </el-input>
                        </template>
                    </div> -->
                    <div class="col-md-3 col-lg-3">
                        <label for="seller_id">Productos</label>

                        <el-select
                            filterable
                            clearable
                            v-model="search.item_id"
                            class="border-left rounded-left border-info w-100"
                            popper-class="el-select-customers"
                            placeholder="Seleccione un producto"
                            @change="getRecords"
                        >
                            <el-option
                                v-for="(option, idx) in items"
                                :key="idx"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <label for="seller_id">Clientes</label>

                        <el-select
                            filterable
                            clearable
                            v-model="search.customer_id"
                            class="border-left rounded-left border-info w-100"
                            popper-class="el-select-customers"
                            placeholder="Seleccione un producto"
                            @change="getRecords"
                        >
                            <el-option
                                v-for="(option, idx) in customers"
                                :key="idx"
                                :value="option.id"
                                :label="option.name"
                            ></el-option>
                        </el-select>
                    </div>
                    <!-- <div class="col-lg-4 col-md-4 ">
                        <div class="form-group">
                            <label class="control-label w-100">Clientes</label>

                            <el-select
                                v-model="search.customer_id"
                                filterable
                                remote
                                popper-class="el-select-customers"
                                clearable
                                placeholder="Nombre o número de documento"
                                :remote-method="searchRemoteCustomers"
                                :loading="loading_search"
                            >
                                <el-option
                                    v-for="option in customers"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div> -->
                    <div
                        class="col-md-3 d-flex align-items-center justify-content-center"
                    >
                        <el-button
                            type="success"
                            size="small"
                            icon="el-icon-tickets"
                            @click.prevent="clickDownload('excel')"
                        >
                            Exportar Excel
                        </el-button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <br />
                    <table class="table table-striped">
                        <thead>
                            <slot name="heading"></slot>
                        </thead>
                        <tbody>
                            <slot
                                v-for="(row, index) in records"
                                :row="row"
                                :index="customIndex(index)"
                            ></slot>
                        </tbody>
                        <tfoot>
                            <slot name="footer"> </slot>
                        </tfoot>
                    </table>
                    <div>
                        <el-pagination
                            v-if="resource !== 'caja/cash-transfer/report'"
                            @current-change="getRecords"
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
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";

export default {
    props: {
        typeUser: {
            type: String,
            default: "admin"
        },
        sellers: {
            type: Array,
            default: () => []
        },
        resource: String,
        applyFilter: {
            type: Boolean,
            default: true,
            required: false
        },
        fromAdmin: {
            type: Boolean,
            default: false,
            required: false
        },
        config: Object
    },
    data() {
        return {
            cashes: [],
            search: {
                column: null,
                value: null,
                item_id: null,
                customer_id: null
            },
            columns: [],
            records: [],
            pagination: {},
            array_district: [],
            time: null,
            warehouses: [],
            areas: [],
            items: [],
            customers: []
        };
    },
    computed: {},
    created() {
        this.$http.get(`/warranty/tables`).then(response => {
            console.log(response);
            this.items = response.data.items;
            this.customers = response.data.customers;
            console.log(this.customers);
        });
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
        if (this.resource == "caja/cash-transfer/report") {
            this.getCashes();
        }
        if (this.resource == "items") {
            this.$http.get(`/warehouses/records`).then(response => {
                this.warehouses = response.data.data;
            });

            this.$http.get(`/caja/areas/records`).then(response => {
                this.areas = response.data.data;
            });
        }
    },
    async mounted() {
        let column_resource = this.resource; // _.split(this.resource, '/')
        await this.$http.get(`/${this.resource}/columns`).then(response => {
            this.columns = response.data;
            this.search.column = _.head(Object.keys(this.columns));
        });
        if (this.resource !== "caja/cash-transfer/report") {
            await this.getRecords();
        }
    },
    methods: {
        total_income() {
            return this.records.reduce(
                (acc, item) => acc + Number(item.income),
                0
            );
        },
        total_expense() {
            return this.records.reduce(
                (acc, item) => acc + Number(item.expense),
                0
            );
        },
        /* clickDownload(type) {
            this.$emit("clickReport", this.search, type);
        }, */
        clickDownload() {
            let parameters = this.getQueryParameters();
            window.open(
                `/${this.resource}/export_excel?${parameters}`,
                "_blank"
            );
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
        /* getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                let url = `/${
                    this.resource
                }/records?${this.getQueryParameters()}`;
                if (this.fromAdmin) {
                    url = `/${
                        this.resource
                    }/records?${this.getQueryParameters()}&fromAdmin=true`;
                }
                return this.$http.get(url).then(response => {
                    if (this.resource !== "caja/cash-transfer/report") {
                        this.records = response.data.data;
                        this.pagination = response.data.meta;
                        this.pagination.per_page = parseInt(
                            response.data.meta.per_page
                        );
                    } else {
                        let data = response.data;
                        this.records = data.data;
                    }
                });
            }, 350);
        }, */

        getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                let url = `/${
                    this.resource
                }/records?${this.getQueryParameters()}`;
                if (this.fromAdmin) {
                    url = `/${
                        this.resource
                    }/records?${this.getQueryParameters()}&fromAdmin=true`;
                }

                return this.$http.get(url).then(response => {
                    let data = response.data;

                    // Verificación y transformación de los registros
                    if (this.resource !== "caja/cash-transfer/report") {
                        this.records = data.data.map(record => {
                            const producto =
                                record.producto_sale_note ??
                                record.producto_document;

                            const productoDescripcion = producto
                                ? producto.description
                                : "N/A";
                            const productoInternalId = producto
                                ? producto.internal_id
                                : "N/A";
                            const productoMonth = producto
                                ? producto.month_day
                                : "N/A";

                            const item =
                                record.document_item?.item ||
                                record.sale_note_item?.item ||
                                record.document_customer?.item ||
                                record.sale_note_customer?.item ||
                                null;

                            const customer = record.document_customer ||
                                record.sale_note_customer || {
                                    id: "N/A",
                                    name: "N/A",
                                    number: "N/A"
                                };

                            // Asigna el item al registro si lo encontró
                            return {
                                ...record,
                                item: item ? item : "N/A",
                                customer: {
                                    id: customer.id,
                                    name: customer.name,
                                    number: customer.number
                                },
                                producto_descripcion: productoDescripcion,
                                producto_internal_id: productoInternalId,
                                producto_month_day: productoMonth
                            };
                        });

                        // Actualiza la paginación
                        this.pagination = data.meta;
                        this.pagination.per_page = parseInt(data.meta.per_page);
                    } else {
                        // Si es el caso especial de "caja/cash-transfer/report"
                        this.records = data.data;
                    }
                });
            }, 350);
        },

        getQueryParameters() {
            if (
                this.search.column == "date" &&
                this.search.value &&
                typeof this.search.value == "object"
            ) {
                this.search.value = this.search.value.join(",");
            }
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                value: this.search.value,
                column: this.search.column,
                item_id: this.search.item_id,
                customer_id: this.search.customer_id,
                end_date: this.search.end_date,
                warehouse_id: this.search.warehouse_id
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
