<template>
    <div>
        <div class="row ">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 mb-2">
                        <div class="form-group d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                                <label class="control-label font-custom mb-0"><strong>Filtros de Busqueda de Lotes</strong></label>
                                <template v-if="!see_more">
                                    <a class="control-label font-weight-bold text-info font-custom ml-2" href="#" @click="clickSeeMore">
                                        <strong>[+ Ver más]</strong>
                                    </a>
                                </template>
                                <template v-else>
                                    <a class="control-label font-weight-bold text-info font-custom ml-2" href="#" @click="clickSeeMore">
                                        <strong>[- Ver menos]</strong>
                                    </a>
                                </template>
                            </div>
                            <div class="d-flex align-items-center" v-if="see_more">
                                <el-button class="btn_buscarsmall" type="primary" @click.prevent="getRecords"
                                    :loading="loading_submit" icon="el-icon-search"
                                    style="width: auto; min-width: 0; padding: 0 10px; display: inline-flex; align-items: center;">
                                    Buscar
                                </el-button>
                                <el-button class="btn_limpiarsmall btn_limpiarsmall:hover" type="" @click.prevent="cleanInputs"
                                    icon="el-icon-delete"
                                    style="width: auto; min-width: 0; padding: 0 10px; display: inline-flex; align-items: center;">
                                    Limpiar
                                </el-button>
                                <el-button class="btn_excelsmall" v-if="resource == 'lotes' && records.length > 0"
                                    type="" @click.prevent="exportRecords"
                                    style="width: auto; min-width: 0; padding: 0 10px; display: inline-flex; align-items: center;">
                                    <i class="icofont-file-excel"></i>
                                    <span style="margin-left: 5px;">Exportar</span>
                                </el-button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row mb-3" v-if="see_more">
                    <div class="col-md-6">
                        <div class="card" style="padding: 12px 6px;">
                            <div class="card-body" style="padding: 0px 0px;">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label class="control-label w-100">
                                                <i class="el-icon-collection-tag mr-1"></i>
                                                Lote
                                            </label>
                                            <el-input placeholder="Ingresar" v-model="search.lote">
                                                <i slot="prefix" class="el-icon-edit-outline"></i>
                                            </el-input>
                                            <br />
                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="control-label w-100">
                                                <i class="el-icon-goods mr-1"></i>
                                                Productos
                                                <el-checkbox v-model="search.date_of_due">
                                                    <el-tooltip content="Muestra todos los lotes vencidos y con stock"
                                                        placement="top">
                                                        <i class="el-icon-warning-outline mr-1" style="color: red;"></i>
                                                    </el-tooltip>
                                                    <span style="color: red;">Vencidos</span>
                                                </el-checkbox>
                                            </label>
                                            <el-select class="w-100" v-model="search.item_id" filterable remote
                                                popper-class="el-select-customers" clearable
                                                placeholder="Nombre o código interno" :remote-method="searchRemoteItems"
                                                :loading="loading_search_item">
                                                <el-option v-for="option in items" :key="option.id" :value="option.id"
                                                    :label="option.description"></el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label class="control-label w-100">
                                                <i class="el-icon-office-building mr-1"></i>
                                                Almacén
                                            </label>
                                            <el-select class="w-100" v-model="search.warehouse_id" clearable>
                                                <el-option v-for="option in warehouses" :key="option.id"
                                                    :value="option.id" :label="option.description"></el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="padding: 12px 6px;">
                            <div class="card-body" style="padding: 0px 0px;">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label w-100">
                                                <i class="el-icon-date mr-1"></i>
                                                Rango Fecha:
                                            </label>
                                            <el-select class="w-100" v-model="search.date_filter" clearable>
                                                <el-option v-for="option in due_date_filter" :key="option.id"
                                                    :value="option.value" :label="option.label"></el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 ">
                                        <div class="form-group">
                                            <label class="control-label w-100">
                                                <!-- Vacio -->
                                            </label>
                                            <template v-if="search.date_filter == 'week'">
                                                <el-date-picker v-model="search.date_filter_value"
                                                    :picker-options="optionPicker" type="week" value-format="yyyy-MM-dd"
                                                    :format="customFormat" placeholder="Semana">
                                                </el-date-picker>
                                            </template>
                                            <template v-if="search.date_filter == 'month'">
                                                <el-date-picker v-model="search.date_filter_value" type="month"
                                                    value-format="yyyy-MM-dd" placeholder="Mes">
                                                </el-date-picker>
                                            </template>
                                            <template v-if="search.date_filter == 'year'">
                                                <el-date-picker v-model="search.date_filter_value" type="year"
                                                    value-format="yyyy-MM-dd" placeholder="Año">
                                                </el-date-picker>
                                            </template>
                                            <template v-if="search.date_filter == 'between'">
                                                <el-date-picker v-model="search.d_start" type="date"
                                                    style="width: 100%;" placeholder="Inicial" value-format="yyyy-MM-dd"
                                                    @change="changeDisabledDates">
                                                </el-date-picker>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 " v-if="search.date_filter == 'between'">
                                        <div class="form-group">
                                            <label class="control-label w-100">
                                                <!-- Vacio -->
                                            </label>
                                            <el-date-picker v-model="search.d_end" type="date" value-format="yyyy-MM-dd"
                                                :disabled="!search.d_start" style="width: 100%;" placeholder="Final"
                                                :picker-options="pickerOptionsDates" @change="changeEndDate">
                                            </el-date-picker>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <!-- <div class="d-flex align-items-center justify-content-end">
                        <el-button class="btn_buscarsmall" type="primary" @click.prevent="getRecords"
                            :loading="loading_submit" icon="el-icon-search"
                            style="width: auto; min-width: 0; padding: 0 10px; display: inline-flex; align-items: center;">
                            Buscar
                        </el-button>
                        <el-button class="btn_limpiarsmall btn_limpiarsmall:hover" type="" @click.prevent="cleanInputs"
                            icon="el-icon-delete"
                            style="width: auto; min-width: 0; padding: 0 10px; display: inline-flex; align-items: center;">
                            Limpiar
                        </el-button>
                        <el-button class="btn_excelsmall" v-if="resource == 'lotes' && records.length > 0" type=""
                            @click.prevent="exportRecords"
                            style="width: auto; min-width: 0; padding: 0 10px; display: inline-flex; align-items: center;">
                            <i class="icofont-file-excel"></i>
                            <span style="margin-left: 5px;">Exportar</span>
                        </el-button>
                    </div> -->
                </div>


            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <slot name="heading"></slot>
                        </thead>
                        <tbody v-loading="loading">
                            <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
                        </tbody>
                    </table>
                    <div>
                        <el-pagination @current-change="getRecords" layout="total, prev, pager, next"
                            :total="pagination.total" :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page">
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
            due_date_filter: [
                {
                    id: 1,
                    label: "Semana",
                    value: "week"
                },
                {
                    id: 2,
                    label: "Mes",
                    value: "month"
                },
                {
                    id: 3,
                    label: "Año",
                    value: "year"
                },
                {
                    id: 4,
                    label: "Entre fechas",
                    value: "between"
                }
            ],
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
            loading: false,
            optionPicker: {
                firstDayOfWeek: 1
            }
        };
    },
    computed: {
        customFormat() {
            return "WW [semana] - M [mes]";
            return {
                week: "Semana WW",
                month: "MMMM"
            };
        }
    },

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
        getWeekNumber(date) {
            const d = new Date(date);
            d.setHours(0, 0, 0, 0);
            d.setDate(d.getDate() + 4 - (d.getDay() || 7));
            const yearStart = new Date(d.getFullYear(), 0, 1);
            return Math.ceil(((d - yearStart) / 86400000 + 1) / 7);
        },
        exportRecords() {
            let url = `/${this.resource}/excel?${this.getQueryParameters()}`;
            window.open(url, "_blank");
        },
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
                active: true,
                date_filter: "week",
                date_of_due: Date.now()
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
        getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                let url = `/${this.resource
                    }/records?${this.getQueryParameters()}`;
                if (this.fromAdmin) {
                    url = `/${this.resource
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
            const today = moment().format("YYYY-MM-DD");
            if (this.search.d_start == null) {
                this.search.d_end = null;
            }

            const params = {
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            };

            if (this.search.date_of_due === true) {
                params.date_of_due = today;
            } else {
                delete params.date_of_due;
            }

            return queryString.stringify(params);

            /* return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            }); */
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
                            // this.filterItems();
                        }
                    });
            } else {
                // this.filterItems();
            }
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
