<template>
    <div>
        <div class="row">
            <el-pagination
                    @current-change="getRecords"
                    layout="total, prev, pager, next"
                    :total="pagination.total"
                    :current-page.sync="pagination.current_page"
                    :page-size="pagination.per_page">
            </el-pagination>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table table-striped table-hover" style="width:100%;     white-space: nowrap;">
                        <thead>
                        <slot name="heading"></slot>
                        </thead>
                        <tbody>
                        <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    
    </div>
</template>
<script>
/* import exportVue from "../../../../../Format/Resources/assets/js/views/account/export.vue"; */

export default {
    props:["input_searchItems"],
    watch: {input_searchItems(inputValue,_){
        if(inputValue.length <3 ){
            
                
                this.getRecords();
            }
            if(inputValue.length >= 3 ){
               
                this.getRecords();
                
            }
    }},
    data() {
        return {
            search: {
                    column: null,
                    value: null
                },
            columns: [],
            records: [],
            pagination: {},
            array_district:[],
            resource: 'reports/stockmin',
            currentRequest: null
        }
    },
    async mounted() {
         this.getRecords();
    },
    methods: {
       async getRecords(){
            let values= this.input_searchItems
            
            let url = ``
            if(values != '' && values != null && values != undefined ){
                
                url=`/${this.resource}/records/${values}?page=${this.pagination.current_page}`
            }else{
                values = 'campoVacio'; 
                url=`/${this.resource}/records/${values}?page=${this.pagination.current_page}`
            }
            if (this.currentRequest) {
                this.currentRequest.cancel();
            }
            this.currentRequest = this.$http.CancelToken.source();
            
            try {
                const response = await this.$http.get(url,{ cancelToken: this.currentRequest.token });

                const { status ,data} = response;
                if(status == 200) {
                    this.records = response.data.data
                    this.pagination= data
                }else{
                    console.log(response)
                }
            } catch (error) {
                if(this.$http.isCancel(error)){
                    console.log(error)
                }else{
                    this.$toast.error(error.message)
                }
            }
        },
        customIndex(index) {
                if(this.pagination.per_page == undefined){
                    this.pagination.per_page = 0 
                }
               
                return (this.pagination.per_page * (this.pagination.current_page - 1)) + index + 1
            },
    }
}
</script>