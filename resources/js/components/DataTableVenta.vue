<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="form-group">
                            <label class="control-label font-custom">
                                <strong>Filtros de busqueda</strong>
                            </label>
                            <template v-if="!see_more">
                                <a
                                    class="control-label font-weight-bold text-info font-custom"
                                    href="#"
                                    @click="clickSeeMore"
                                >
                                    <strong>[+ Ver más]</strong>
                                </a>
                            </template>
                            <template v-else>
                                <a
                                    class="control-label font-weight-bold text-info font-custom"
                                    href="#"
                                    @click="clickSeeMore"
                                >
                                    <strong>[- Ver menos]</strong>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" v-if="see_more">
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label class="control-label w-100"
                                >Tipo comprobante</label
                            >
                            <el-select
                                v-model="search.document_type_id"
                                @change="changeDocumentType"
                                popper-class="el-select-document_type"
                                filterable
                                clearable
                            >
                                <el-option
                                    v-for="option in document_types"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="control-label w-100">Serie</label>
                            <el-select
                                v-model="search.series"
                                filterable
                                clearable
                            >
                                <el-option
                                    v-for="option in series"
                                    :key="option.number"
                                    :value="option.number"
                                    :label="option.label"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="control-label w-100">Número</label>
                            <el-input
                                placeholder="Ingresar"
                                v-model="search.number"
                                clearable
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 pb-2">
                        <div class="form-group">
                            <label class="control-label w-100">Mes</label>
                            <el-date-picker
                                v-model="search.d_end"
                                type="month"
                                style="width: 100%;"
                                placeholder="Buscar"
                                value-format="yyyy-MM"
                                format="MM/yyyy"
                                :picker-options="pickerOptionsDates"
                                @change="changeEndDate"
                            ></el-date-picker>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                        <label class="control-label w-100"
                            >Fecha de emisión</label
                        >
                        <el-date-picker
                            v-model="search.date_of_issue"
                            type="date"
                            style="width: 100%;"
                            placeholder="Buscar"
                            value-format="yyyy-MM-dd"
                            @change="changeDateOfIssue"
                        ></el-date-picker>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                        <label class="control-label w-100"
                            >Año</label
                        >
                        <el-date-picker
                            v-model="search.year"
                            type="year"
                            style="width: 100%;"
                            placeholder="Buscar"
                            value-format="yyyy"
                            @change="changeDateOfIssue"
                        ></el-date-picker>
                    </div>
                    <div class="col-lg-4 col-md-4 ">
                    <div class="form-group">
                        <label class="control-label w-100">Clientes</label>

                        <el-select v-model="search.customer_id" filterable remote popper-class="el-select-customers" clearable placeholder="Nombre o número de documento" :remote-method="searchRemoteCustomers" :loading="loading_search">
                            <el-option v-for="option in customers" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                    </div>
                </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                        <div class="form-group">
                            <label class="control-label w-100"
                                >Condición de pago</label
                            >
                            <el-select
                                v-model="search.payment_condition_id"
                                filterable
                                clearable
                            >
                                <el-option
                                    v-for="option in payment_conditions"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label class="control-label w-100">Productos</label>
                            <el-select
                                class="w-100"
                                v-model="search.item_id"
                                filterable
                                remote
                                popper-class="el-select-customers"
                                clearable
                                placeholder="Nombre o código interno"
                                :remote-method="searchRemoteItems"
                                :loading="loading_search_item"
                            >
                                <el-option
                                    v-for="option in items"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label class="control-label w-100"
                                >Establecimiento</label
                            >
                            <el-select
                                v-model="search.establishments"
                                @change="changestablishment"
                                popper-class="el-select-establishment"
                                filterable
                                clearable
                            >
                                <el-option
                                    v-for="option in establishments"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
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
                            >
                                <el-option
                                    v-for="option in categories"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div
                        class="col-lg-2 col-md-2 col-sm-12 pb-2"
                    >
                        <div class="form-group">
                            <label class="control-label w-100">Unidad De Medida</label>
                            <el-select
                                v-model="search.unit_type_id"
                                filterable
                                clearable
                            >
                                <el-option
                                    v-for="option in unit_types"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div
                        class="col-lg-2 col-md-2 col-sm-12 pb-2"
                    >
                        <div class="form-group">
                            <label class="control-label w-100">Usuario</label>
                            <el-select
                                v-model="search.user_id"
                                filterable
                                clearable
                            >
                                <el-option
                                    v-for="option in users"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div
                        class="col-lg-3 col-md-3 col-md-3 col-sm-12"
                        style="margin-top:29px"
                    >
                        <el-button
                            class="submit"
                            type="primary"
                            @click.prevent="getRecordsByFilter"
                            :loading="loading_submit"
                            icon="el-icon-search"
                            >Buscar</el-button
                        >
                        <el-button
                            class="submit"
                            type="info"
                            @click.prevent="cleanInputs"
                            icon="el-icon-delete"
                            >Limpiar</el-button
                        >
                        <el-button
                            class="submit"
                            type="success"
                            v-if="records.length > 0"
                            @click.prevent="exportRecordsVentas"
                            icon="el-icon-download"
                            :disabled="!search.d_end && !search.date_of_issue && !search.customer_id && !search.year"
                            >Exportar</el-button
                        >
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
                    <table class="table table-striped" v-loading="loading">
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
                        ></el-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.font-custom {
    font-size: 15px !important;
}
</style>
<script>
import moment from "moment";
import queryString from "query-string";
import $ from "jquery";

export default {
    props: {
        resource: String
    },
    data() {
        return {
            loading_submit: false,
            columns: [],
            loading: false,
            records: [],
            customers: [],
            all_customers: [],
            items: [],
            all_items: [],
            loading_search: false,
            loading_search_item: false,
            document_types: [],
            categories: [],
            state_types: [],
            pagination: {},
            search: {},
            all_series: [],
            establishment: null,
            establishments: [],
            series: [],
            activePanel: 0,
            payment_conditions: [],
            sellers: [],
            unit_types: [],
            users: [],
            see_more: false,
            totals: null,
            totalSum: 0,
            pickerOptionsDates: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM-DD");
                    return this.search.d_start > time;
                }
            }
        };
    },
    computed: {},
    created() {
        this.initForm();
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {
        this.$http.get(`/${this.resource}/data_table`).then(response => {
            this.sellers = response.data.sellers;
            this.all_customers = response.data.customers;
            this.all_items = response.data.items;
            this.categories = response.data.categories;
            this.state_types = response.data.state_types;
            this.document_types = response.data.document_types;
            this.all_series = response.data.series;
            this.establishments = response.data.establishments;
            this.payment_conditions = response.data.payment_conditions;
            this.configuration = response.data.configuration;
            this.unit_types = response.data.unit_types;
            this.users = response.data.users;
        });

        await this.getRecords();
        await this.filterCustomers();
        await this.filterItems();
        await this.cargalo();
    },
    methods: {
        changeEndDate(value) {
            this.search.d_end = value;
        },
        changeDateOfIssue(value) {
            this.search.date_of_issue = value;
        },
        getTotals(records) {
            this.totals = _.sumBy(records, it => parseFloat(it.total));
        },
        searchRemoteItems(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/data-table/items?${parameters}`)
                    .then(response => {
                        // console.log(response.data)
                        this.items = response.data;
                        this.loading_search = false;

                        if (this.items.length == 0) {
                            this.filterItems();
                        }
                    });
            } else {
                this.filterItems();
            }
        },
        filterItems() {
            this.items = this.all_items;
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/data-table/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;

                        if (this.customers.length == 0) {
                            this.filterCustomers();
                        }
                    });
            } else {
                this.filterCustomers();
            }
        },
        filterCustomers() {
            this.customers = this.all_customers;
        },
        clickSeeMore() {
            this.see_more = this.see_more ? false : true;
        },
        initForm() {
            this.search = {
                establishment: null,
                series: null,
                item_id: null,
                warehouse_id: null,
                unit_type_id: null,
                has_sale: false,
                active: false,
                series: null,
                number: null,
                d_start: null,
                d_end: null,
                year: null,
                pending_payment: false
            };
        },
        changestablishment() {
            /* this.filterEstablishments(); */
        },

        filterEstablishments() {
            if (this.search.establishments) {
                this.establishments = _.filter(this.establishments, est => {
                    return est.id === this.search.establishments;
                });
            } else {
                this.establishments = this.establishments;
            }
        },

        changeDocumentType() {
            this.filterSeries();
        },
        filterSeries() {
            this.search.series = null;
            this.series = _.filter(this.all_series, {
                document_type_id: this.search.document_type_id
            });
            this.search.series =
                this.series.length > 0 ? this.series[0].number : null;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getRecordsByFilter() {
            this.loading_submit = await true;
            await this.getRecords();
            this.loading_submit = await false;
        },
        exportRecords() {
            let parameters = this.getQueryParameters();
            window.open(`/${this.resource}/excel?${parameters}`, "_blank");
        },
        exportRecordsVentas() {
            let parameters = this.getQueryParameters();
            window.open(
                `/${this.resource}/ventas/excel?${parameters}`,
                "_blank"
            );
        },
        getRecords() {
            this.loading_submit = true;
            this.loading = true;
            return this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.data;
                    /* this.totalSum = response.data.total_sum; */

                    if (
                        response.data.data &&
                        response.data.data.length > 0 &&
                        response.data.data[0].total_sum
                    ) {
                        this.totalSum = response.data.data[0].total_sum;
                    }
                    this.getTotals(this.records);
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                })
                .finally(() => {
                    this.loading_submit = false;
                    this.loading = false;
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
            // this.getRecords()
        },
        changeDisabledDates() {
            this.search.date_of_issue = null;
            if (this.search.d_end < this.search.d_start) {
                this.search.d_end = this.search.d_start;
            }
        },
        changeDateOfIssue() {
            this.search.d_start = null;
            this.search.d_end = null;
        },
        changeEndDate() {
            this.search.date_of_issue = null;
        },
        cleanInputs() {
            this.initForm();
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
