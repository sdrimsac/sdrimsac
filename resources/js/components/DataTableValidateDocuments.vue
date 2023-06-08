<template>
    <div>
        <div class="row ">

            <div class="col-md-12 col-lg-12 col-xl-12 ">
                  
                <div class="row mt-2"> 
                     <div class="col-md-2">
                            <label class="control-label">Periodo</label>
                            <el-select v-model="form.period" @change="changePeriod">
                                <el-option key="month" value="month" label="Por mes"></el-option>
                                <el-option key="between_months" value="between_months" label="Entre meses"></el-option>
                                <el-option key="date" value="date" label="Por fecha"></el-option>
                                <el-option key="between_dates" value="between_dates" label="Entre fechas"></el-option>
                            </el-select>
                    </div>
                    <template v-if="form.period === 'month' || form.period === 'between_months'">
                            <div class="col-md-2">
                                <label class="control-label">Mes de</label>
                                <el-date-picker v-model="form.month_start" type="month"
                                                @change="changeDisabledMonths"
                                                value-format="yyyy-MM" format="MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'between_months'">
                            <div class="col-md-2">
                                <label class="control-label">Mes al</label>
                                <el-date-picker v-model="form.month_end" type="month"
                                                :picker-options="pickerOptionsMonths"
                                                value-format="yyyy-MM" format="MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'date' || form.period === 'between_dates'">
                            <div class="col-md-2">
                                <label class="control-label">Fecha del</label>
                                <el-date-picker v-model="form.date_start" type="date"
                                                @change="changeDisabledDates"
                                                value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'between_dates'">
                            <div class="col-md-2">
                                <label class="control-label">Fecha al</label>
                                <el-date-picker v-model="form.date_end" type="date"
                                                :picker-options="pickerOptionsDates"
                                                value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                     <div class="col-lg-2 col-md-2 ">
                        <div class="form-group" :class="{'has-danger': errors.document_type_id}"> 
                            <label class="control-label">Comprobante<span class="text-danger"> *</span></label>
                             <el-select v-model="form.document_type_id">
                               <el-option v-for="option in document_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                               
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.document_type_id" v-text="errors.document_type_id[0]"></small>
                        </div>
                    </div>
                  
                     
                    <div class="col-lg-4 col-md-4 col-md-4 col-sm-12 mt-4"> 
                        <el-button class="submit" type="primary" @click.prevent="getRecordsByFilter" :loading="loading_submit" icon="el-icon-check" >Validar documentos</el-button>
                        <el-button class="submit" type="info" @click.prevent="cleanInputs"  icon="el-icon-delete" >Limpiar </el-button>

                    </div>             
                    
                </div>
                <div class="row mt-1 mb-3">
                    
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
                columns: [],
                records: [],
                customers: [],
                document_types: [],
                state_types: [],
                pagination: {}, 
                errors: {}, 
                form: {}, 
                all_series: [], 
                series: [],            
                see_more:false, 
                pickerOptionsDates: {
                disabledDate: (time) => {
                    time = moment(time).format('YYYY-MM-DD')
                    return this.form.date_start > time
                    }
                },
                pickerOptionsMonths: {
                disabledDate: (time) => {
                    time = moment(time).format('YYYY-MM')
                    return this.form.month_start > time
                    }
                },
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
            await this.$http.get(`/${this.resource}/data_table`).then((response) => {
                this.document_types = response.data.document_types
                this.all_series = response.data.series
                this.form.document_type_id = (this.document_types.length > 0) ? this.document_types[0].id : null
                this.changeDocumentType()
            });
            this.initForm()

            // await this.getRecords()

        },
        methods: {
            clickSeeMore(){
                this.see_more = (this.see_more) ? false : true
            },
            initForm(){
                this.form = {
                    document_type_id:"01",
                   period: 'month',
                    date_start:moment().startOf('month').format('YYYY-MM-DD'),
                    date_end: moment().endOf('month').format('YYYY-MM-DD'),
                    month_start: moment().format('YYYY-MM'),
                    month_end: moment().format('YYYY-MM'),
                }

            },
              changeDisabledDates() {
                if (this.form.date_end < this.form.date_start) {
                    this.form.date_end = this.form.date_start
                }
                // this.loadAll();
            },
            changeDocumentType(){                
              //  this.filterSeries();
            },
            async filterSeries() {
                this.search.series = null
                this.series = await _.filter(this.all_series, {'document_type_id': this.search.document_type_id});
                this.search.series = (this.series.length > 0)?this.series[0].number:null
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
                
                this.$eventHub.$emit('valueLoading', true)
                return this.$http.get(`/${this.resource}/validate?${this.getQueryParameters()}`).then((response) => {
                    this.records = response.data.data
                    this.pagination = response.data.meta
                    this.pagination.per_page = parseInt(response.data.meta.per_page)
                    this.loading_submit = false
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data 
                        console.log(error.response.data)
                    } else {
                        console.log(error.response)
                    }
                })
                .then(() => {
                    this.loading_submit = false
                    this.$eventHub.$emit('valueLoading', false)
                });

            },
            getQueryParameters() {
                return queryString.stringify({
                    page: this.pagination.current_page,
                    limit: this.limit,
                    ...this.form
                })
            },
            changeClearInput(){
                this.search.value = ''
                // this.getRecords()
            }, 
            cleanInputs(){
                this.initForm()
            },
             changeDisabledMonths() {
                 this.form.month_end=this.form.month_start
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