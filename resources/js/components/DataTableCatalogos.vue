<template>
    <div>
        <div class="row " v-loading="loading">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row" v-if="applyFilter">
                    
                    <div
                        class="col-lg-2 col-md-2 col-sm-12 pb-2"
                    >
                        <div class="form-group">
                            <label class="control-label w-100">Categoría</label>
                            <el-select
                                v-model="search.category_id"
                                filterable
                                clearable
                                @change="getRecords"
                            >
                                <el-option
                                    v-for="(option, idx) in categories"
                                    :key="idx"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div
                        class="col-lg-2 col-md-2 col-sm-12 pb-2"
                    >
                    <el-button
                        class="submit"
                        type="danger"
                        icon="el-icon-tickets"
                        @click.prevent="exportRecords"
                        >Exportar PDF</el-button
                    >
                        
                    </div>
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
                warehouse_id: 1,
                column: null,
                value: null,
                active: null
            },
            columns: [],
            records: [],
            pagination: {},
            array_district: [],
            time: null,
            warehouses: [],
            areas: [],
            loading: false,
        };
    },
    computed: {},
    created() {
        
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
        /* if (this.resource == "caja/cash-transfer/report") {
            this.getCashes();
        }
        if (this.resource == "items") {
            this.$http.get(`/warehouses/records`).then(response => {
                this.warehouses = response.data.data;
            });

            this.$http.get(`/caja/areas/records`).then(response => {
                this.areas = response.data.data;
            });
        } */
    },
    async mounted() {
        /* let column_resource = this.resource; // _.split(this.resource, '/')
        await this.$http.get(`/${this.resource}/columns`).then(response => {
            this.columns = response.data;
            this.search.column = _.head(Object.keys(this.columns));
        });
        if (this.resource !== "caja/cash-transfer/report") {
            await this.getRecords();
        } */
        this.getRecords();
    },
    methods: {
        /* exportRecords() {
            window.open(
                `/${this.resource}/pdf?${this.getQueryParameters()}`,
                "_blank"
            );
        }, */
        exportRecords() {
            let parameters = this.getQueryParameters();
            window.open(
                `/${this.resource}/pdf?${parameters}`,
                "_blank"
            );
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
              
                end_date: this.search.end_date,
                warehouse_id: this.search.warehouse_id,
                
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>