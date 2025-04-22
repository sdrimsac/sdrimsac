<template>
    <div>
        <div class="row " v-loading="loading">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row" v-if="applyFilter">
                    <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                        <label for="value">
                            Buscar
                        </label>
                        <template>
                            <el-select v-model="search.food_id" 
                                placeholder="Buscar" 
                                @change="getRecords" 
                                clearable 
                                filterable>
                                <el-option
                                    v-for="item in foods"
                                    :key="item.id"
                                    :label="item.description"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </template>
                    </div>
                    <div
                       
                        class="col-lg-3 col-md-3 col-sm-12 pb-2"
                    >
                        <label for="value">
                            Desde
                        </label>
                        <el-date-picker
                            v-model="search.date_start"
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
                    >
                        <label for="value">
                            Hasta
                        </label>
                        <el-date-picker
                            v-model="search.date_end"
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
                    >
                        <label for="value">
                            Dia
                        </label>
                        <el-date-picker
                            v-model="search.date"
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
                </div>
            </div>
            <div v-if="resource == 'items'" class="row"></div>
            <div
                v-if="
                    resource == 'caja/worker/expenses' ||
                        ('purchases' && records.length != 0)
                "
                class="row"
            >
                <div
                    class="col-md-6 d-flex"
                    v-if="resource !== 'caja/cash-transfer'"
                >
                    <el-button
                        class="submit"
                        type="success"
                        v-if="
                            resource !== 'item-color-size'"
                        icon="el-icon-tickets"
                        @click.prevent="clickDownload('excel')"
                        >Exportar Excel</el-button
                    >

                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <br />
                    <table
                        class="table table-striped"
                        id="scroll2"
                        style="overflow-x: auto"
                    >
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
                date_start: null,
                date_end: null,
                date: null,
                food_id: null,
                
            },
            columns: [],
            records: [],
            pagination: {},
            array_district: [],
            time: null,
            warehouses: [],
            areas: [],
            loading: false,
            foods: [],
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
        await this.$http.get(`/${this.resource}/columns`).then(response => {
            this.columns = response.data;
            this.search.column = _.head(Object.keys(this.columns));
        });
        if (this.resource !== "caja/cash-transfer/report") {
            await this.getRecords();
        }

        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.foods = response.data.foods;  
        });
    },
    methods: {
        clickAddProductsToPolitica() {
            this.loading = true;
            this.$http.get(`/items/warehouse`).then(response => {
                this.$showSAlert("EXITO", "Politicas agreagadas correctamente a todos los almacenes", "success");
                /* this.$toast.success("Politicas agregadas correctamente a todos los almacenes"); */
                this.getRecords();
            }).catch(error => {
                this.loading = false;
            }).finally(() => {
                this.loading = false;
            });
        },


        clickAddProductsToWarehouses() {
            this.loading = true;
            this.$http.get(`/items/warehouses/add-products`).then(response => {
                this.$toast.success("Productos agregados correctamente a todos los almacenes");
                this.getRecords();
            }).catch(error => {
                this.loading = false;
            }).finally(() => {
                this.loading = false;
            });
        },
    
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
        getCashes() {
            this.$http
                .get(`/caja/cash-transfer/cashes-principal`)
                .then(response => {
                    this.cashes = response.data.cashes;
                    let [cash] = this.cashes;
                    if (cash) {
                        this.search.cash_id = cash.id;
                        this.getRecords();
                    }
                });
        },
        clickDownload(type) {

            window.open(
                `/${this.resource}/exportExcel?${this.getQueryParameters()}&type=${type}`,
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
        getRecords() {

            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.loading = true;
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
                }).catch(error => {
                    this.loading = false;
                }).finally(() => {
                    this.loading = false;
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
                active: this.search.active,
                date_start: this.search.date_start,
                date_end: this.search.date_end,
                date: this.search.date,
                food_id: this.search.food_id,
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>