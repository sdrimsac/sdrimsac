<template>
    <el-dialog :title="titleDialog" :visible="showDialog_report" @close="close" @open="create">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.group_id}">
                            <label class="control-label">Grupo</label>
                            <el-select v-model="form.group_id" clearable>
                                <el-option v-for="option in array_group" :key="option.id" :value="option.id" :label="option.group"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.group_id" v-text="errors.group_id[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.category_id}">
                              <label class="control-label">Categoria</label>
                                <el-select v-model="form.category_id" clearable>
                                  <el-option v-for="option in array_categorias" :key="option.id" :value="option.id" :label="option.category"></el-option>
                                </el-select>
                            <small class="form-control-feedback" v-if="errors.category_id" v-text="errors.category_id[0]"></small>
                        </div>
                       
                    </div>
                <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.subcategory_id}">
                              <label class="control-label">Subcategoria</label>
                              <el-select v-model="form.subcategory_id" clearable>
                                  <el-option v-for="option in array_subcategorias" :key="option.id" :value="option.id" :label="option.subcategory"></el-option>
                                </el-select>
                            <small class="form-control-feedback" v-if="errors.subcategory_id" v-text="errors.subcategory_id[0]"></small>
                        </div>
                       
                    </div>
                </div>
                <div class="row">
                    
                       <div class="col-md-3">
                            <label class="control-label">Periodo</label>
                            <el-select v-model="form.period" @change="changePeriod">
                                <el-option key="month" value="month" label="Por mes"></el-option>
                                <el-option key="between_months" value="between_months" label="Entre meses"></el-option>
                                <el-option key="date" value="date" label="Por fecha"></el-option>
                                <el-option key="between_dates" value="between_dates" label="Entre fechas"></el-option>
                            </el-select>
                        </div>
                        <template v-if="form.period === 'month' || form.period === 'between_months'">
                            <div class="col-md-3">
                                <label class="control-label">Mes de</label>
                                <el-date-picker v-model="form.month_start" type="month"
                                                @change="changeDisabledMonths"
                                                value-format="yyyy-MM" format="MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'between_months'">
                            <div class="col-md-3">
                                <label class="control-label">Mes al</label>
                                <el-date-picker v-model="form.month_end" type="month"
                                                :picker-options="pickerOptionsMonths"
                                                value-format="yyyy-MM" format="MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'date' || form.period === 'between_dates'">
                            <div class="col-md-3">
                                <label class="control-label">Fecha del</label>
                                <el-date-picker v-model="form.date_start" type="date"
                                                @change="changeDisabledDates"
                                                value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'between_dates'">
                            <div class="col-md-3">
                                <label class="control-label">Fecha al</label>
                                <el-date-picker v-model="form.date_end" type="date"
                                                :picker-options="pickerOptionsDates"
                                                value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        </template>
                   
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button class="submit" type="primary" @click.prevent="getRecordsByFilter" :loading="loading_submit" icon="el-icon-search" >Buscar</el-button>

            </div>
        </form>
    </el-dialog>

</template>

<script>
      import moment from 'moment'
    import queryString from 'query-string'
    import {EventBus} from '../../helpers/bus'
    export default {
        props: ['showDialog_report'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'expensesbox',
                form: {},
                array_subcategorias: [],
                array_categorias:[],
                array_group:[],
                register_group:false,
                register_category:false,
                register_subcategory:false,
                form_group:[],
                form_category:[],
                form_subcategory:[],
                pagination: {},
                search: {},
             }
        },
        created() {
            this.initForm()

            this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.array_group = response.data.gruop
                    this.array_categorias = response.data.category
                    this.array_subcategorias = response.data.subcategory
                })
//            await this.$http.get(`/${this.resource}/record`)
//                .then(response => {
//                    if (response.data !== '') {
//                        this.form = response.data.data
//                    }
//                })
        },
        methods: {
         
            initForm() {
                this.errors = {}
                this.form = {
                    id: null,
                    user_id: null,
                    group_id: null,
                    category_id: null,
                    subcategory_id: null,
                    type: 2,
                    state: 1,
                     period: 'month',
                    date_start: moment().format('YYYY-MM-DD'),
                    date_end: moment().format('YYYY-MM-DD'),
                    month_start: moment().format('YYYY-MM'),
                    month_end: moment().format('YYYY-MM'),
                }
                
            },
          
            create() {
                this.titleDialog = 'Reporte de Arqueo de Caja'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                        })
                }
            },
              async getRecordsByFilter(){

                this.loading_submit = await true
                await this.getRecords()
                this.loading_submit = await false

            },
            getRecords() {
                window.open(`/expensesbox/reports?${this.getQueryParameters()}`, '_blank');
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
            close() {
                this.$emit('update:showDialog_report', false)
                this.initForm()
            },
        }
    }
</script>
