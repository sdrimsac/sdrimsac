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
                    <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
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
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                        <label for="value">
                            Serie de Producto
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
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                        <label for="value">
                            Cliente
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
                    </div>
                    <div
                        v-if="
                            search.column == 'date_of_issue' ||
                                search.column == 'date_of_due' ||
                                search.column == 'date_of_payment' ||
                                search.column == 'delivery_date' ||
                                (search.column == 'date' &&
                                    resource == 'purchases' &&
                                    search.value)
                        "
                        class="col-lg-3 col-md-3 col-sm-12 pb-2"
                    >
                        <label for="value">
                            Hasta
                        </label>
                        <el-date-picker
                            v-model="search.end_date"
                            type="date"
                            style="width: 100%;"
                            placeholder="Buscar"
                            value-format="yyyy-MM-dd"
                            @change="getRecords"
                        >
                        </el-date-picker>
                    </div>
                    <div
                        class="col-lg-3 col-md-3 col-sm-12 pb-2"
                        v-if="resource == 'items'"
                    >
                        <label for="warehouse">
                            Almacén
                        </label>
                        <el-select
                            clearable
                            v-model="search.warehouse_id"
                            @change="getRecords"
                            placeholder="Seleccione el Almacén"
                        >
                            <el-option
                                v-for="item in warehouses"
                                :key="item.id"
                                :label="item.description"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </div>
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
                value: null
            },
            columns: [],
            records: [],
            pagination: {},
            array_district: [],
            time: null,
            warehouses: [],
            areas: []
        };
    },
    computed: {},
    created() {
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
                            // Verifica cuál de los dos (document_item o sale_note_item) tiene el item
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
                                }
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
