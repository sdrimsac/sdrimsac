<template>
    <div>
        <div class="row ">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row" v-if="applyFilter">
                    <div class="col-lg-2 col-md-2">
                        <label for="serie">Serie</label>
                        <el-select
                            @change="getRecords"
                            placeholder="Serie"
                            v-model="search.series"
                            filterable
                            clearable
                        >
                            <el-option
                                v-for="option in series"
                                :key="option.number"
                                :value="option.number"
                                :label="option.number"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="control-label w-100">Número Nota Venta</label>
                            <el-input
                                placeholder="Ingresar"
                                v-model="search.number"
                                @input="getRecords"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
                        <label for="date_start">Fecha Emision</label>
                        <el-date-picker
                            v-model="search.date_start"
                            type="date"
                            style="width: 100%;"
                            placeholder="Fecha inicial"
                            value-format="yyyy-MM-dd"
                            @change="getRecords"
                        >
                        </el-date-picker>
                    </div>
                    <div class="col-md-2 col-lg-3">
                        <label for="date_end">Mes</label>

                        <el-date-picker
                            v-model="search.date_end"
                            type="month"
                            style="width: 100%;"
                            placeholder="Mes"
                            value-format="yyyy-MM"
                            format="MM/yyyy"
                            @change="getRecords"
                        >
                        </el-date-picker>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <label for="seller_id">Vendedor</label>

                        <el-select
                            clearable
                            v-model="search.seller_id"
                            class="border-left rounded-left border-info w-100"
                            popper-class="el-select-customers"
                            placeholder="Seleccione un Asesor - Vendedor"
                            @change="getRecords"
                        >
                            <el-option
                                v-for="(option, idx) in sellers"
                                :key="idx"
                                :value="option.id"
                                :label="option.name"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-2 col-lg-2">
                        <label for="state_type_id">Estado</label>

                        <el-select
                            clearable
                            v-model="search.state_type_id"
                            placeholder="Seleccione un estado"
                            @change="getRecords"
                        >
                            <el-option
                                v-for="(option, idx) in state_types"
                                :key="idx"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="control-label w-100">Productos</label>
                            <el-input
                                placeholder="Ingrese nombre del producto"
                                v-model="search.description"
                                @input="getRecords"
                                clearable
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                        </div>
                    </div>
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
                    <!-- <div class="col-md-3 col-lg-3">
                        <label for="seller_id">Vendedor</label>

                        <el-select
                            clearable
                            v-model="search.seller_id"
                            class="border-left rounded-left border-info w-100"
                            popper-class="el-select-customers"
                            placeholder="Seleccione un Asesor - Vendedor"
                            @change="getRecords"
                        >
                            <el-option
                                v-for="(option, idx) in sellers"
                                :key="idx"
                                :value="option.id"
                                :label="option.name"
                            ></el-option>
                        </el-select>
                    </div> -->
                    <div class="col-md-6 col-sm-12">
                        <el-button
                            type="success"
                            icon="el-icon-download"
                            size="small"
                            v-if="records.length > 0"
                            @click="exportRecords"
                            :disabled="!search.date_start && !search.date_end"
                        >
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="debe seleccionar al menos una fecha unico o mes para poder exportar a excel"
                                placement="top-start"
                            >
                                <i class="fa fa-download"></i>
                            </el-tooltip>
                            Exportar
                        </el-button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="scroll1" style="overflow-x: auto">
                    <div style="height: 20px"></div>
                </div>
                <div
                    class="table-responsive"
                    id="scroll2"
                    style="overflow-x: auto"
                >
                    <table class="table table-hover table-striped">
                        <thead>
                            <slot name="heading"></slot>
                        </thead>
                        <tbody>
                            <slot
                                v-for="(row, index) in records"
                                :row="row"
                                :index_="customIndex(index)"
                            ></slot>
                        </tbody>
                    </table>
                    <div>
                        <el-pagination
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

<style>
td {
    color: #000;
}
</style>
<script>
import moment from "moment";
import queryString from "query-string";

export default {
    props: {
        resource: String,
        applyFilter: {
            type: Boolean,
            default: true,
            required: false
        }
    },
    data() {
        return {
            items: [],
            categories: [],
            state_types: [],
            sellers: [],
            customers: [],
            loading_search: false,
            search: {
                state_type_id: "01",
                number: null,
                customer_id: null,
                date_start: null,
                date_end: null,
                seller_id: null,
                category_id: null,
                series: null,
                end: null
            },
            totals: {
                total_pen: 0,
                total_paid_pen: 0,
                total_pending_paid_pen: 0
            },
            columns: [],
            records: [],
            pagination: {},
            array_users: [],
            series: [],
            saleNotesPending: 0
            // sale_notes_pending:0
        };
    },
    computed: {},
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
            /* this.getTotals(); */
            // this.filter_users()
        });
        this.$http.get(`/sale-notes/tables`).then(response => {
            console.log(response);
            this.array_users = response.data.users;
            this.sellers = response.data.sellers;
            this.categories = response.data.categories;
            this.state_types = response.data.state_types;
        });
    },
    async mounted() {
        let column_resource = _.split(this.resource, "/");
        // console.log(column_resource)
        await this.$http
            .get(`/${_.head(column_resource)}/columnsVenta`)
            .then(response => {
                this.columns = response.data;
                this.search.column = _.head(Object.keys(this.columns));
            });

        await this.$http
            .get(`/${_.head(column_resource)}/columns2`)
            .then(response => {
                this.series = response.data.series;
            });

        await this.getRecords();
    },
    methods: {
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/${this.resource}/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.allCustomers();
                        }
                    });
            } else {
                this.allCustomers();
            }
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        exportRecords() {
            window.open(
                `/${this.resource}/excel?${this.getQueryParameters()}`,
                "_blank"
            );
        },
        getRecords() {
            return this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                });
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
