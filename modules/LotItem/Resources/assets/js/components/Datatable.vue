<template>
    <div>
        <div class="row ">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="form-group">
                            <label class="control-label font-custom"
                                ><strong>Filtros de busqueda</strong></label
                            >
                            <template v-if="!see_more">
                                <a
                                    class="control-label font-weight-bold text-info font-custom"
                                    href="#"
                                    @click="clickSeeMore"
                                    ><strong> [+ Ver más]</strong></a
                                >
                            </template>
                            <template v-else>
                                <a
                                    class="control-label font-weight-bold text-info font-custom"
                                    href="#"
                                    @click="clickSeeMore"
                                    ><strong> [- Ver menos]</strong></a
                                >
                            </template>
                        </div>
                    </div>
                </div>
                <div class="row mt-2" v-if="see_more">
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="control-label w-100">Series</label>
                            <el-input
                                placeholder="Ingresar"
                                v-model="search.series"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 ">
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
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label class="control-label w-100">Almacén</label>
                            <el-select
                                class="w-100"
                                v-model="search.warehouse_id"
                                clearable
                            >
                                <el-option
                                    v-for="option in warehouses"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 pb-2">
                        <div class="form-group">
                            <label class="control-label w-100"
                                >Fecha inicio
                            </label>

                            <el-date-picker
                                v-model="search.d_start"
                                type="date"
                                style="width: 100%;"
                                placeholder="Buscar"
                                value-format="yyyy-MM-dd"
                                @change="changeDisabledDates"
                            >
                            </el-date-picker>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 pb-2">
                        <div class="form-group">
                            <label class="control-label w-100"
                                >Fecha término</label
                            >

                            <el-date-picker
                                v-model="search.d_end"
                                type="date"
                                :disabled="!search.d_start"
                                style="width: 100%;"
                                placeholder="Buscar"
                                value-format="yyyy-MM-dd"
                                :picker-options="pickerOptionsDates"
                                @change="changeEndDate"
                            >
                            </el-date-picker>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                        <div class="form-group">
                            <el-checkbox v-model="search.has_sale"
                                >Vendido</el-checkbox
                            >
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 pb-2">
                        <div class="form-group">
                            <el-checkbox v-model="search.active"
                                >Activo</el-checkbox
                            >
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-md-4 col-sm-12">
                        <el-button
                            class="submit"
                            type="primary"
                            @click.prevent="getRecords"
                            :loading="loading_submit"
                            icon="el-icon-search"
                            >Buscar</el-button
                        >
                        <el-button
                            class="submit"
                            type="success"
                            @click="excel"
                            :loading="loading_submit"
                            
                            >
    <i class="fas fa-file-excel"></i>
                            Excel</el-button
                        >

                        <el-button
                            class="submit"
                            type="info"
                            @click.prevent="cleanInputs"
                            icon="el-icon-delete"
                            >Limpiar
                        </el-button>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <slot name="heading"></slot>
                        </thead>
                        <tbody v-loading="loading">
                            <slot
                                v-for="(row, index) in records"
                                :row="row"
                                :index="customIndex(index)"
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

<script>
import queryString from "query-string";
import moment from "moment";
export default {
    props: {
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
        }
    },
    data() {
        return {
            items: [],
            warehouses: [],
            loading_submit: false,
            loading_search_item: false,
            pickerOptionsDates: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM-DD");
                    return this.search.d_start > time;
                }
            },
            search: {},
            columns: [],
            records: [],
            pagination: {},
            array_district: [],
            time: null,
            see_more: false,
            loading: false
        };
    },
    computed: {},

    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {
        // let column_resource = this.resource; // _.split(this.resource, '/')
        // await this.$http.get(`/${this.resource}/columns`).then(response => {
        //     this.columns = response.data;
        //     this.search.column = _.head(Object.keys(this.columns));
        // });
        this.initForm();
        await this.getWarehouses();
        await this.getRecords();
    },
    methods: {
        async getWarehouses() {
            try {
                const response = await this.$http(`${this.resource}/tables`);
                console.log(response);
                const { data } = response;
                this.warehouses = data.warehouses;
            } catch (e) {
                console.log(e);
            }
        },
        initForm() {
            this.search = {
                series: null,
                item_id: null,
                warehouse_id: null,
                d_start: null,
                d_end: null,
                has_sale: false,
                active: true
            };
        },
        cleanInputs() {
            this.initForm();
        },
        changeEndDate() {
            this.search.date_of_issue = null;
        },
        changeDateOfIssue() {
            this.search.d_start = null;
            this.search.d_end = null;
        },
        changeDisabledDates() {
            this.search.date_of_issue = null;
            if (this.search.d_end < this.search.d_start) {
                this.search.d_end = this.search.d_start;
            }
        },
        clickSeeMore() {
            this.see_more = this.see_more ? false : true;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
         excel() {
            let url = `/${this.resource}/excel?${this.getQueryParameters()}`;
            if (this.fromAdmin) {
                url = `/${
                    this.resource
                }/excel?${this.getQueryParameters()}&fromAdmin=true`;
            }
           window.open(url, "_blank");
        },
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
                try {
                    this.loading = true;
                    const response = await this.$http.get(url);
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                } catch (e) {
                } finally {
                    this.loading = false;
                }
            }, 350);
        },
        getQueryParameters() {
            if (this.search.d_start == null) {
                this.search.d_end = null;
            }
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            });
        },
        searchRemoteItems(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/data-table/items?series=1&${parameters}`)
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
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
