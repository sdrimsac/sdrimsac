<template>
    <div>
        <h1>Listado De utiles en el Almacen  </h1>
        <div class="row col-md-12">
            <div class="col-md-4 col-12">
                <el-select v-model="form.salon"   clearable filterable @change="getRecords">
                <el-option v-for="item in dataSalones"
                    :key="item.id"
                    :value="item.id"
                    :label="item.degres_desc"
                    ></el-option>
                
                 </el-select>
            </div>
            <div class="col-md-4 col-12">
                <el-input v-model="form.inputnameItem" @input="getRecords" placeholder="Ingrese Nombre del Util Escolar" size="small" ></el-input>
            </div>
            
            
        </div>
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
export default {
    props: ["salones"],
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
            resource: 'listsuplies',
            dataSalones: [] ,
            form: {}
            
        }
    },
    mounted(){
        this.getRecords()
        
        

        this.dataSalones = [...this.salones.original.salones.map(s =>{
                            s.degres_desc = `${s.degres_desc}  ${s.lvl_desc} ${s.sect_desc}`
                             
                            return {
                             ...s              
                              };
                    })];
                    
    },
    methods:{
        async getRecords(){

            let values = {salon: this.form.salon, inputnameItem: this.form.inputnameItem}
            let url = ``
           
            
            
            
            if((values.salon != '' && values.salon != null && values.salon != undefined ) ||(values.inputnameItem != '' && values.inputnameItem != null && values.inputnameItem != undefined ) ){//undefined indica que el campo esta vacio (la informacion que se esta buscando es sin el filtro )
                url=`${this.resource}/datosTablaAlmacen/?page=${this.pagination.current_page}`
            }
            else{
                values.salon = 'campoVacio'; 
                values.inputnameItem = 'campoVacio'; 
                url=`${this.resource}/datosTablaAlmacen/?page=${this.pagination.current_page}`
            }
            


            try{ 
               const response = await axios.post(url, {
                salon: values.salon, inputnameItem: values.inputnameItem
               });
               const  {data} = response 
               
               
               this.records = data.data 
               this.pagination= data
            } catch(e){}

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
