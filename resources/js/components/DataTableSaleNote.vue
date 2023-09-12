<template>
    <div>
        <div class="row ">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row" v-if="applyFilter">
                    <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
                        <div class="d-flex">
                            <div style="width:100px">
                                Filtrar por:
                            </div>
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
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2"
                    
                    
                    >
                        <div class="form-group">
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
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
                        <template
                            v-if="
                                search.column == 'date_of_issue' ||
                                    search.column == 'date_of_due' ||
                                    search.column == 'date_of_payment'
                            "
                        >
                            <el-date-picker
                                v-model="search.value"
                                type="date"
                                style="width: 100%;"
                                placeholder="Fecha inicial"
                                value-format="yyyy-MM-dd"
                                @change="getRecords"
                            >
                            </el-date-picker>
                        </template>
                        <template v-else-if="search.column == 'seller_id'">
                            <el-select
                                clearable
                                v-model="search.value"
                                class="border-left rounded-left border-info w-100"
                                popper-class="el-select-customers"
                                placeholder="Seleccione un Asesor - Vendedor"
                                @change="getRecords"
                            >
                                <el-option
                                    v-for="(option,idx) in sellers"
                                    :key="idx"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                        </template>
                        <template v-else-if="search.column == 'customer_id'">
                            <el-select
                                v-model="search.value"
                                filterable
                                remote
                                class="border-left rounded-left border-info"
                                popper-class="el-select-customers"
                                dusk="customer_id"
                                placeholder="Escriba el nombre o número de documento del cliente"
                                :remote-method="searchRemoteCustomers"
                                :loading="loading_search"
                                @change="getRecords"
                            >
                                <el-option
                                    v-for="option in customers"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </template>
                        <template v-else>
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
                    <div class="col-md-2 col-lg-3">
                         <template
                            v-if="
                                search.column == 'date_of_issue' ||
                                    search.column == 'date_of_due' ||
                                    search.column == 'date_of_payment'
                            "
                        >
                            <el-date-picker
                                v-model="search.end"
                                type="date"
                                style="width: 100%;"
                                placeholder="Fecha final"
                                value-format="yyyy-MM-dd"
                                @change="getRecords"
                            >
                            </el-date-picker>
                        </template>
                    </div>
                  
                    <div class="col-md-6 col-sm-12">
                        <el-button
                            type="success"
                            icon="el-icon-download"
                            size="small"
                            v-if="records.length > 0"
                            @click="exportRecords"
                        >
                            Exportar
                        </el-button>
                    </div>
                      <div class="col-md-2">
                        <el-tag>
                            Total por cobrar {{ saleNotesPending.toFixed(2) }}
                        </el-tag>
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
                                :index="customIndex(index)"
                            ></slot>
                        </tbody>
                    </table>

                    <div class="row mb-5">
                        <div class="col-md-4 text-center ">
                            Total nota de venta en soles S/
                            {{ totals.total_pen }}
                        </div>
                        <div class="col-md-4 text-center ">
                            Total pagado en soles S/ {{ totals.total_paid_pen }}
                        </div>
                        <div class="col-md-4 text-center ">
                            Total por cobrar en soles S/
                            {{ totals.total_pending_paid_pen }}
                        </div>
                    </div>

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
            sellers:[],
            customers: [],
            loading_search: false,
            search: {
                column: null,
                value: null,
                series: null,
                end:null,
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
            this.getTotals();
            // this.filter_users()
        });
        this.$http.get(`/sale-notes/tables`).then(response => {
            this.array_users = response.data.users;
            this.sellers = response.data.sellers;
        });
    },
    async mounted() {
        let column_resource = _.split(this.resource, "/");
        // console.log(column_resource)
        await this.$http
            .get(`/${_.head(column_resource)}/columns`)
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
        await this.getTotals();
        await this.cargalo();
        await this.getCreditPending();
    },
    methods: {
        async getCreditPending() {
            const response = await this.$http("/sale-notes/credit_pending");
            this.saleNotesPending = response.data.sale_notes_pending;
        },
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
        getTotals() {
            this.$http.get(`/${this.resource}/totals`).then(response => {
                // console.log(response)
                this.totals = response.data;
            });
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
        },
        cargalo() {
            $("#scroll1 div").width($(".table").width());
            $("#scroll1").on("scroll", function() {
                $("#scroll2").scrollLeft($(this).scrollLeft());
            });
            $("#scroll2").on("scroll", function() {
                $("#scroll1").scrollLeft($(this).scrollLeft());
            });
        }
    }
};
</script>
