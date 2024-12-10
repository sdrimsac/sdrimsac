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
                </div>
            </div>
            <div v-if="resource == 'items'" class="row"></div>
            <div
                v-if="
                    resource == 'billar/worker/expenses' ||
                        ('purchases' && records.length != 0)
                "
                class="row"
            >
                <div v-if="resource == 'billar/worker/expenses'" class="col-md-3">
                    <el-button
                        class="submit"
                        type="danger"
                        icon="el-icon-tickets"
                        @click.prevent="clickDownload('pdf')"
                        >Exportar PDF</el-button
                    >
                </div>
                <div class="col-md-6 d-flex"
                v-if="resource !== 'caja/cash-transfer'"
                >
                    <el-button
                        class="submit"
                        type="success"
                        v-if="resource !== 'item-color-size'"
                        icon="el-icon-tickets"
                        @click.prevent="clickDownload('excel')"
                        >Exportar Excel</el-button
                    >
                        <el-button
                        class="submit"
                        type="success"
                        v-if="search.warehouse_id && typeUser == 'superadmin'"
                        icon="el-icon-tickets"
                        @click.prevent="clickDownloadForImport('excel')"
                        >Exportar Excel - Formato de importacion</el-button
                    >
                </div>
       
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <br>
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
                            <slot name="footer"
                            
                            >
                                
                            </slot>
                        </tfoot>
                    </table>
                    <div>
                        <el-pagination
                            v-if="resource !== 'billar/cash-transfer/report'"
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
            cashes:[],
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
        if(this.resource == "bilar/cash-transfer/report"){
            this.getCashes();
        }
        if (this.resource == "items") {
            this.$http.get(`/warehouses/records`).then(response => {
                this.warehouses = response.data.data;
            });

            this.$http.get(`/billar/areas/records`).then(response => {
                this.areas = response.data.data;
            });
        }
    },
    async mounted() {
        let column_resource = this.resource; // _.split(this.resource, '/')
        await this.$http.get(`/billar/columns`).then(response => {
            this.columns = response.data;
            this.search.column = _.head(Object.keys(this.columns));
        });
        if(this.resource !== "bilar/cash-transfer/report"){
            await this.getRecords();
        }
    },
    methods: {
        total_income(){
            return this.records.reduce((acc, item) => acc + Number(item.income), 0);
        },
        total_expense(){
            return this.records.reduce((acc, item) => acc + Number(item.expense), 0);
        },
        getCashes() {
            this.$http.get(`/billar/cash-transfer/cashes-principal`).then(response => {
                this.cashes = response.data.cashes;
                let [cash] = this.cashes;
                if(cash){
                    this.search.cash_id = cash.id;
                    this.getRecords();     
                }
            });
        },
        clickDownload(type) {
            this.$emit("clickReport", this.search, type);
        },
        clickDownloadForImport(){
            this.$emit("clickReportForImport", this.search);
        },

        customIndex(index) {

            if(this.resource == "billar/cash-transfer/report" ){
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
                    if(this.resource !== "billar/cash-transfer/report"){
                     this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );   
                    }else{
                        let data = response.data;
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
                cash_id: this.search.cash_id,
                end_date: this.search.end_date,
                warehouse_id: this.search.warehouse_id,
                area_id: this.search.area_id
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
