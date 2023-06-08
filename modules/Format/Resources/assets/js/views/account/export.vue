<template>
    <div>
        <div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>{{ title }}</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">{{ title }}</span></li>
                  </ol>
                </div>
                 
              </div>
            </div>
          </div>
         <div class="container-fluid">
            <div class="card" v-loading="loading">
                <div class="card-header bg-primary">
                    <h6 class="my-0">{{ title }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                            <div class="col-md-4">
                                <label>Periodo</label>
                                <el-date-picker v-model="form.month" type="month"
                                                value-format="yyyy-MM" format="MM/yyyy" :clearable="false"></el-date-picker>
                            </div>
                        <div class="col-md-3">
                            <label>Exportar a</label>
                            <el-select v-model="form.type">
                                <el-option key="concar" value="concar" label="CONCAR"></el-option>
                                <el-option key="siscont" value="siscont" label="SISCONT"></el-option>
                                <el-option key="foxcont" value="foxcont" label="FOXCONT"></el-option>
                            </el-select>
                        </div>
                        
                    </div>
                </div>
            <div class="form-actions text-end pt-2 pb-2">
                    <el-button type="primary" :loading="loading_submit" @click.prevent="clickDownload">
                        <template v-if="loading_submit">
                            Generando...
                        </template>
                        <template v-else>
                            Generar
                        </template>
                    </el-button>
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
</template>

<script>
    import queryString from 'query-string'

    export default {
        data() {
            return {
                loading: false,
                loading_submit: false,
                title: null,
                resource: 'account',
                // establishments: [],
                // document_types: [],
                // series: [],
                error: {},
                form: {},
                // pickerOptionsDates: {
                //     disabledDate: (time) => {
                //         time = moment(time).format('YYYY-MM-DD')
                //         return this.form.date_start > time
                //     }
                // },
                // pickerOptionsMonths: {
                //     disabledDate: (time) => {
                //         time = moment(time).format('YYYY-MM')
                //         return this.form.month_start > time
                //     }
                // },
            }
        },
        async created() {
            // this.loading = true;
            this.initForm();
            this.title = 'Exportar';
            // await this.$http.get(`/${this.resource}/tables`)
            //     .then(response => {
            //         this.establishments = response.data.establishments
            //         this.document_types = response.data.document_types
            //         this.customers = response.data.customers
            //         this.resetForm()
            //     })
            // this.loading = false
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    // establishment_id: 'all',
                    // document_type_id: 'all',
                    // series: 'all',
                    // period: 'month',
                    // date_start: moment().format('YYYY-MM-DD'),
                    // date_end: moment().format('YYYY-MM-DD'),
                    month: moment().format('YYYY-MM'),
                    // month_end: moment().format('YYYY-MM'),
                    type: 'concar'
                }
            },
            // resetForm() {
            //     this.form.establishment_id = (this.establishments.length > 0)?this.establishments[0].id:'all'
            // },
            // changeDocumentType() {
            //     this.form.series = 'all'
            //     if (this.form.document_type_id) {
            //         let establishment = _.find(this.establishments, {'id': this.form.establishment_id})
            //         this.series = _.filter(establishment.series, {'document_type_id': this.form.document_type_id})
            //     } else {
            //         this.series = []
            //     }
            // },
            // changeDisabledDates() {
            //     if (this.form.date_end < this.form.date_start) {
            //         this.form.date_end = this.form.date_start
            //     }
            // },
            // changeDisabledMonths() {
            //     if (this.form.month_end < this.form.month_start) {
            //         this.form.month_end = this.form.month_start
            //     }
            // },
            clickDownload() {
                this.loading_submit = true;
                let query = queryString.stringify({
                    ...this.form
                });
                window.open(`/${this.resource}/download?${query}`, '_blank');
                this.loading_submit = false;
            }
        }
    }
</script>
