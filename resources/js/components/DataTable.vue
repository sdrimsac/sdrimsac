<template>
    <div>
        <div class="row ">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row" v-if="applyFilter">
                    <div class="col-lg-4 col-md-4 col-sm-12 pb-2">
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
                                ></el-option>
                            </el-select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
                        <label for="value">
                            Buscar
                        </label>
                        <template
                            v-if="
                                search.column == 'date_of_issue' ||
                                    search.column == 'date_of_due' ||
                                    search.column == 'date_of_payment' ||
                                    search.column == 'delivery_date' ||
                                    search.column == 'date'
                            "
                        >
                            <template
                                v-if="resource != 'restaurant/worker/expenses'"
                            >
                                <el-date-picker
                                    v-model="search.value"
                                    type="date"
                                    style="width: 100%;"
                                    placeholder="Buscar"
                                    value-format="yyyy-MM-dd"
                                    @change="getRecords"
                                >
                                </el-date-picker>

                             
                            </template>
                            <template v-else>
                                <el-date-picker
                                    v-model="search.value"
                                    type="daterange"
                                    range-separator="A"
                                    start-placeholder="Desde"
                                    value-format="yyyy-MM-dd"
                                    end-placeholder="Hasta"
                                    @change="getRecords"
                                >
                                </el-date-picker>
                            </template>
                        </template>
                        <template v-else-if="search.column == 'district_id'">
                            <el-select
                                v-model="search.value"
                                @change="getRecords"
                                placeholder="Seleccione el Distrito"
                            >
                                <el-option
                                    v-for="item in array_district"
                                    :key="item.id"
                                    :label="item.description"
                                    :value="item.id"
                                >
                                </el-option>
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
                    <div  v-if="
                                search.column == 'date_of_issue' ||
                                    search.column == 'date_of_due' ||
                                    search.column == 'date_of_payment' ||
                                    search.column == 'delivery_date' ||
                                    search.column == 'date'
                                    && resource == 'purchases'  
                                    && search.value
                            " class="col-lg-3 col-md-4 col-sm-12 pb-2">
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
                </div>
            </div>
            <div
                v-if="
                    resource == 'restaurant/worker/expenses' || 'purchases' &&
                        records.length != 0
                "
                class="row"
            >
                <div v-if="resource == 'restaurant/worker/expenses'" 
                class="col-md-3">
                    <el-button
                    
                        class="submit"
                        type="danger"
                        icon="el-icon-tickets"
                        @click.prevent="clickDownload('pdf')"
                        >Exportar PDF</el-button
                    >
                </div>
                  <div class="col-md-3">
                    <el-button
                        class="submit"
                        type="success"
                        icon="el-icon-tickets"
                        @click.prevent="clickDownload('excel')"
                        >Exportar Excel</el-button
                    >
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
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
import moment from "moment";
import queryString from "query-string";

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
        },
        config: Object
    },
    data() {
        return {
            search: {
                column: null,
                value: null
            },
            columns: [],
            records: [],
            pagination: {},
            array_district: [],
            time: null
        };
    },
    computed: {},
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {
        let column_resource = this.resource; // _.split(this.resource, '/')
        await this.$http.get(`/${this.resource}/columns`).then(response => {
            this.columns = response.data;
            this.search.column = _.head(Object.keys(this.columns));
        });
        await this.getRecords();
    },
    methods: {
        clickDownload() {
            this.$emit("clickReport", this.search);
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
            //   this.$http.get(`/filtrar_distritos/records`)
            // .then(response => {
            //     this.array_district = response.data.district

            // })
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
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
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
                end_date: this.search.end_date
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
