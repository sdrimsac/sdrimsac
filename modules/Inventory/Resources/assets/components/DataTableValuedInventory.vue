<template>
    <div>
        <div class="row">

            <div class="col-md-12 col-lg-12 col-xl-12 ">

                <div class="row mt-2">


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Almacen</label>
                                <el-select v-model="form.warehouse_id" clearable filterable>
                                    <el-option v-for="option in warehouses" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                            </div>
                        </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Categoria</label>
                                <el-select v-model="form.category_id" clearable filterable>
                                    <el-option v-for="option in categories" :key="option.id" :value="option.id" :label="option.name"></el-option>
                                </el-select>
                            </div>
                        </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Tipo Reporte</label>
                                <el-select v-model="form.typeresult" clearable filterable>
                                    <el-option value="Detallado" label="Detallado"></el-option>
                                    <el-option value="Resumen" label="Resumen"></el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-md-4 col-sm-12">
                            <el-button class="submit" type="primary" @click.prevent="getRecordsByFilter" :loading="loading_submit" icon="el-icon-search" >Buscar</el-button>
                            <template v-if="records.length>0">

                                <!-- <el-button class="submit" type="danger" @click.prevent="clickDownload('pdf')"><i class="fa fa-file-pdf" ></i>  Exportal PDF</el-button> -->
                                <el-button class="submit" type="success" @click.prevent="clickDownload('excel')"><i class="fa fa-file-excel" ></i>  Exportal Excel</el-button>
                            </template>

                        </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <slot name="heading"></slot>
                        </thead>
                        <tbody>
                            <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
                        </tbody>
                    </table>
                    <div>
                        <el-pagination
                                @current-change="getRecords"
                                layout="total, prev, pager, next"
                                :total="pagination.total"
                                :current-page.sync="pagination.current_page"
                                :page-size="pagination.per_page">
                        </el-pagination>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style>
.font-custom{
    font-size:15px !important
}
</style>
<script>

    import moment from 'moment'
    import queryString from 'query-string'

    export default {
        props: {
            resource: String,
        },
        data () {
            return {
                loading_submit:false,
                loading_search:false,
                columns: [],
                records: [],
                pagination: {},
                search: {},
                totals: {},
                categories: [],
                warehouses: [],
                form: {},
            }
        },
        computed: {
        },
        created() {
            this.initForm()
            this.$eventHub.$on('reloadData', () => {
                this.getRecords()
            })
        },

        async mounted () {
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.warehouses = response.data.warehouses;
                    this.categories=response.data.categories;
                });

             await this.getRecords()
        },
        methods: {
            async clickDownload(type) {
                let query = queryString.stringify({
                    ...this.form
                });
                if(type=="pdf"){
                    window.open(`/${this.resource}/${type}/?${query}`, '_blank');
                }else{
                    // console.log(`/${this.resource}/${type}?${query}`);
                    const response = await this.$http.get(`/${this.resource}/${type}/?${query}`, { responseType: "blob" });
                    const blob = new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
                    const link = document.createElement("a");
                    link.href = URL.createObjectURL(blob);
                    link.download = "Reporte_Inv";
                    link.click();
                    URL.revokeObjectURL(link.href);
                }
            },
            initForm(){

                this.form = {
                    warehouse_id: null,
                    category_id: null,
                    typeresult:'Detallado'
                }

            },
            customIndex(index) {
                return (this.pagination.per_page * (this.pagination.current_page - 1)) + index + 1
            },
            async getRecordsByFilter(){

                this.loading_submit = await true
                await this.getRecords()
                this.loading_submit = await false

            },
            getRecords() {
                return this.$http.get(`/${this.resource}/records?${this.getQueryParameters()}`).then((response) => {
                    this.records = response.data.data
                    this.records = this.records.map(r=>({
                        ...r,
                        realStock:r.stock
                    }));
                    
                    this.pagination = response.data.meta
                    this.pagination.per_page = parseInt(response.data.meta.per_page)
                    this.loading_submit = false
                    // this.initTotals()
                });


            },
            getQueryParameters() {
                return queryString.stringify({
                    page: this.pagination.current_page,
                    limit: this.limit,
                    ...this.form
                })
            },

            changeDisabledDates() {
                if (this.form.date_end < this.form.date_start) {
                    this.form.date_end = this.form.date_start
                }
                // this.loadAll();
            },
            changeDisabledMonths() {
                if (this.form.month_end < this.form.month_start) {
                    this.form.month_end = this.form.month_start
                }
                // this.loadAll();
            },
            changePeriod() {
                if(this.form.period === 'month') {
                    this.form.month_start = moment().format('YYYY-MM');
                    this.form.month_end = moment().format('YYYY-MM');
                }
                if(this.form.period === 'between_months') {
                    this.form.month_start = moment().startOf('year').format('YYYY-MM'); //'2019-01';
                    this.form.month_end = moment().endOf('year').format('YYYY-MM');;
                }
                if(this.form.period === 'date') {
                    this.form.date_start = moment().format('YYYY-MM-DD');
                    this.form.date_end = moment().format('YYYY-MM-DD');
                }
                if(this.form.period === 'between_dates') {
                    this.form.date_start = moment().startOf('month').format('YYYY-MM-DD');
                    this.form.date_end = moment().endOf('month').format('YYYY-MM-DD');
                }
                // this.loadAll();
            },
        }
    }
</script>
