<template>
    <div>
       <div class="row"> 
            <div class="col-md-3">
                <label class="control-label">Fecha del</label>
                <el-date-picker v-model="form.date_start" type="date"
                                @change="changeDisabledDates"
                                value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"></el-date-picker>
            </div>

            <div class="col-md-3">
                <label class="control-label">Fecha al</label>
                <el-date-picker v-model="form.date_end" type="date"
                                :picker-options="pickerOptionsDates"
                                value-format="yyyy-MM-dd" format="dd/MM/yyyy" :clearable="false"></el-date-picker>
            </div>
            <div class="col-lg-6 col-md-6" >
                <div class="form-group"> 
                    <label class="control-label">Vendedor
                    </label>
                    
                    <el-select v-model="form.seller_id" filterable  popper-class="el-select-customers"  clearable
                        placeholder="Nombre"
                        @change="changeSellers">
                        <el-option v-for="option in sellers" :key="option.id" :value="option.id" :label="option.name"></el-option>
                    </el-select>
                </div>
            </div> 
            <div class="col-lg-12 col-md-12 col-md-12 col-sm-12 mt-2"> 
            <el-button class="submit" type="primary" @click.prevent="getRecordsByFilter" :loading="loading_submit" icon="el-icon-search" >Buscar</el-button>
            <template v-if="records.length>0"> 
                <!-- <el-button class="submit" type="success" @click.prevent="clickDownload('excel')"><i class="fa fa-file-excel" ></i>  Exportal Excel</el-button> -->
                <el-button class="submit" type="danger"  icon="el-icon-tickets" @click.prevent="clickDownload('pdf')" >Exportar PDF</el-button>
                    <el-button class="submit" type="success"  icon="fa fa-file-excel" @click.prevent="clickDownload('excel')" >Exportar Excel</el-button>
            </template>

           </div> 
       </div>
       <div class="row"  >
            <div class="col-md-3 pt-3">
                <!-- Tabs nav -->
            <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link mb-3 p-3 shadow active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">Pedidos</span></a>

                <a class="nav-link mb-3 p-3 shadow" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                    <i class="fas fa-file-alt mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">Nota de Venta</span></a>

                <a class="nav-link mb-3 p-3 shadow" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                    <i class="fas fa-file-alt mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">Factura  / Boleta de Venta</span></a>

                <a class="nav-link mb-3 p-3 shadow" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                    <i class="fas fa-receipt mr-2"></i>
                    <span class="font-weight-bold small text-uppercase">Resumen</span></a>
                </div> 
            </div>  
            <div class="col-md-9 pt-3">
                 <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade shadow rounded  show active p-2" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                         <table class="table">
                            <thead>
                            <slot name="heading"></slot>
                            </thead>
                            <tbody> 
                                <slot v-for="(row, index) in array_pedidos" :row="row" :index="customIndex(index)"></slot>
                            </tbody> 
                            <tfoot >
                                <tr>
                                    <td colspan="2" align="right"><strong>Total</strong></td>
                                    <td class="text-center">{{totals}}</td>
                                    <td class="text-center">{{totals_import}}</td>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="tab-pane fade shadow rounded  p-2" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                         <table class="table">
                            <thead>
                            <slot name="heading"></slot>
                            </thead>
                            <tbody> 
                                <slot v-for="(row, index) in array_notaventa" :row="row" :index="customIndex(index)"></slot>
                            </tbody> 
                            <tfoot >
                                <tr>
                                    <td colspan="2" align="right"><strong>Total</strong></td>
                                    <td class="text-center">{{totals}}</td>
                                    <td class="text-center">{{totals_import}}</td>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="tab-pane fade shadow rounded  p-2" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <table class="table">
                            <thead>
                            <slot name="heading"></slot>
                            </thead>
                            <tbody> 
                                <slot v-for="(row, index) in array_sales" :row="row" :index="customIndex(index)"></slot>
                            </tbody> 
                            <tfoot >
                                <tr>
                                    <td colspan="2" align="right"><strong>Total</strong></td>
                                    <td class="text-center">{{totals}}</td>
                                    <td class="text-center">{{totals_import}}</td>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="tab-pane fade shadow rounded  p-2" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                         <table class="table">
                            <thead>
                            <slot name="heading"></slot>
                            </thead>
                            <tbody> 
                                <slot v-for="(row, index) in array_balances" :row="row" :index="customIndex(index)"></slot>
                            </tbody> 
                            <tfoot >
                                <tr>
                                    <td colspan="2" align="right"><strong>Total</strong></td>
                                    <td class="text-center">{{totals}}</td>
                                    <td class="text-center">{{totals_import}}</td>
                                </tr> 
                            </tfoot>
                        </table>
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
                activeName: 'first',
                loading_submit:false,
                persons: [],
                all_persons: [],
                loading_search:false,
                columns: [],
                records: [],
                date_range_types: [],
                document_types: [],
                order_state_types: [],
                sellers: [],
                pagination: {}, 
                search: {}, 
                totals: {}, 
                establishment: null,
                form: {}, 
                array_balances:[],
                array_notaventa:[],
                array_pedidos:[],
                array_sales:[],
                pickerOptionsDates: {
                    disabledDate: (time) => {
                        time = moment(time).format('YYYY-MM-DD')
                        return this.form.date_start > time
                    }
                },
                totals:0,
                totals_import:0,
                totals_price:0
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
            await this.$http.get(`/${this.resource}/filter`)
                .then(response => {
                    this.all_persons = response.data.persons
                    this.order_state_types = response.data.order_state_types
                    this.date_range_types = response.data.date_range_types
                    this.sellers = response.data.sellers
                    this.document_types = response.data.document_types
                    this.form.establishment_id=response.data.establishment.id
                  
                });


            // await this.getRecords()
            await this.filterPersons()
            // await this.getTotals()
            this.form.type_person = 'customers'

        },
        methods: { 
            handleClick(tab, event) {
                console.log(tab, event);
            },
            changeDisabledDates() {
                if (this.form.date_end < this.form.date_start) {
                    this.form.date_end = this.form.date_start
                }
                // this.loadAll();
            },
            changePersons(){
                this.form.seller_id = null
                this.$eventHub.$emit('changeFilterColumn', 'person')
                // this.records = []
            },
            changeSellers(){
                this.form.person_id = null
                this.$eventHub.$emit('changeFilterColumn', 'seller')
                // this.records = []
            },
            searchRemotePersons(input) {  
                
                if (input.length > 0) { 

                    this.loading_search = true
                    let parameters = `input=${input}`
                    
                    this.form.type_person = 'customers'

                    this.$http.get(`/reports/data-table/persons/${this.form.type_person}?${parameters}`)
                            .then(response => { 
                                this.persons = response.data.persons
                                this.loading_search = false
                                
                                if(this.persons.length == 0){
                                    this.filterPersons()
                                }
                            })  
                } else {
                    this.filterPersons()
                }

            },
            filterPersons() { 
                this.persons = this.all_persons
            }, 
            clickDownload(type) {                 
                let query = queryString.stringify({
                    ...this.form
                });
             
                window.open(`/${this.resource}/${type}/?${query}`, '_blank');
            },
            initForm(){
 
                this.form = {
                  //  person_id: null,
                  //  period:'date',
                  //  month_start:moment().startOf('month').format('YYYY-MM-DD'), 
                  //  month_end:moment().endOf('month').format('YYYY-MM-DD'), 
                  //  document_type_id: null,
                   // establishment_id: null,
                  //  date_range_type_id: 'date_of_issue',
                  //  order_state_type_id: 'all_states',
                   // type_person:null,
                  //  seller_id:null,
                    user_id:null,
                    date_start: moment().startOf('month').format('YYYY-MM-DD'), 
                    date_end: moment().endOf('month').format('YYYY-MM-DD'), 
                }

            },  
            customIndex(index) {
                return (this.pagination.per_page * (this.pagination.current_page - 1)) + index + 1
            }, 
            async getRecordsByFilter(){
                
               // if(!this.form.person_id &&  !this.form.seller_id){
               //     return this.$toast.error('Debe seleccionar un cliente o vendedor')
               // }

                this.loading_submit = await true
                await this.getRecords()
                await this.getTotals()
                await this.getTotals_import()
                this.loading_submit = await false

            },
            getTotals(){
                this.totals = _.sumBy(this.records, (it) => parseFloat(it.quantity));
            },
              getTotals_import(){
                this.totals_import = _.sumBy(this.records, (it) => parseFloat(it.total));
            },
            getRecords() {
                return this.$http.get(`/${this.resource}/records?${this.getQueryParameters()}`).then((response) => {
                    this.array_pedidos = response.data.pedidos
                    this.array_notaventa = response.data.notaventa
                    this.array_sales = response.data.sales
                    this.array_balances = response.data.balances
                    //this.pagination = response.data.meta
                  //  this.pagination.per_page = parseInt(response.data.meta.per_page)
                    this.loading_submit = false
                    //this.form.establishment_id=
                });


            },
            getQueryParameters() {
                return queryString.stringify({
                    page: this.pagination.current_page,
                    limit: this.limit,
                    ...this.form
                })
            }, 
        }
    }
</script>