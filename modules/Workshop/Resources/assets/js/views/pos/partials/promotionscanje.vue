<template>
    <el-dialog :visible="showDialog" append-to-body @close="close"  @open="open" width="60%"   
        title="Canjear Promocion ">
        <div class="card p-2 mt-3" v-loading="loading">
            <div class="card-body col-12">
                <div class="row col-12">
                    <div class="col-md-6">
                        <label class="control-label">Buscar Cliente</label> 
                        <el-select v-model="form.clientecanje"  placeholder="Buscar cliente con canje" clearable filterable @change="getProducts">
                            <el-option v-for="item in recordsClientes"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                        
                    </div>
                    <div class="col-md-6" v-loading="loadingProdcutos">
                        <label class="control-label">Buscar Producto Promocion </label> 
                        <el-select v-model="form.productos"  placeholder="Busca el producto que daras para cubrir promocion" clearable filterable @change="cantidadDisponible">
                            <el-option v-for="item in recordsProductos"
                                :key="item.id"
                                :label="item.description"
                                :value="item.id">
                            </el-option>
                        </el-select>
                        
                    </div>
                </div>
                <div class="row col-12 d-flex justify-content-between mt-2" >
                    <div class="col-md-3">
                        <label class="control-label">Acceder a la Produccion</label> 
                        <div class="col-md-6">
                            <el-input v-model="form.promotion_count" size="small"  disabled  ></el-input>
                        </div>
                        
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Items  Acumulados</label> 
                        <div class="col-md-6">
                            <el-input v-model="form.acumulateItems" size="small"  disabled  ></el-input>
                        </div>
                        
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Items por Canjear</label> 
                        <div class="col-md-6">
                            <el-input v-model="form.PromoDisponibles" size="small"  disabled  ></el-input>
                        </div>
                        
                    </div>
                    <div class="col-md-3 align-self-end"  >
                        <label class="control-label">Total a reclamar</label> 
                        
                        <input type="text"
                            class="form-control text-center"
                            v-model="TotalReclamar"
                            v-on:keydown="validateNumber"
                             />
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card p-2 mt-3">
            <div class="card-body col-12">
                <div class="row">
                    <el-pagination
                            @current-change="getProducts"
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page">
                    </el-pagination>
                </div>
                <div class=" table-responsive">
                    <table class="table table table-striped table-hover" style="width:100%;     white-space: nowrap;">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>FECHA DE CANJE</td>
                                <td>Cantidad</td>
                                <td>Detalle</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, idx)  in histCambios " :key="idx">
                            <td>{{ idx  + 1  }}</td>
                            <td>{{ data.fecha_cambio }}</td>
                            <td>{{ data.cantidad }}</td>
                            <td>{{ data.description }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                

            </div>
        </div>
        <span slot="footer">
            <el-button  :loading="loading_generar" @click="canjearPromo()" class="btn bg-primary">Canjear Promo </el-button>
                
        </span>
    </el-dialog>
</template>
<style>
    .el-dialog__header {
        background-color: var(--primary) !important; 
    }
    .el-dialog__title {
        color: var(--light-text) !important;
    }
    .el-dialog__headerbtn .el-dialog__close{
        color:white !important;
    }
</style>
<script>
import DocumentPrintDetail from "./document_print_detail.vue";
import queryString from "query-string";
export default {
    components: { DocumentPrintDetail },
    props: ["showDialog", "company", "sender","config", "establishment"],
    data() {
        return {
            time: null,
            loading: false,
            value: null,
            loading_generar : false ,
            form: {},
            recordsClientes : [],
            recordsProductos: [],
            loadingProdcutos: false ,
            loadingHist: false ,
            TotalReclamar: '' ,
            histCambios: [] ,
            pagination: {},

        };
    },
    watch: {TotalReclamar(inputValue,_){
        console.log(inputValue)
        
        if(inputValue > this.form.PromoDisponibles){
                    
                    this.TotalReclamar = this.form.PromoDisponibles
                } 
    }},
    methods: {
        validateNumber(evt){
            
            if (evt.keyCode >= 65 && evt.keyCode <=90  ) 
                {
                    evt.preventDefault();
                }  
        },
        open(){
            this.form = {}
            this.histCambios = []
            this.getdata();
        },
        close(){
            this.$emit("update:showDialog", false)
        }, 
        async canjearPromo(){
            if (this.form.productos == null || this.form.productos == undefined  ||  this.form.PromoDisponibles == null || this.form.PromoDisponibles == undefined ||  this.form.clientecanje  == null || this.form.clientecanje  == undefined || this.TotalReclamar == null || this.TotalReclamar == undefined){
                this.$toast.error('Recuerde rellenar todos los campos');
                return 
            }

            this.loading_generar = true 
            try {
                const response = await axios.post(`pos/canjearPromo`,{
                    form: this.form, 
                    TotalReclamar: this.TotalReclamar
                });

                const {status, data } = response

                if(status === 200){
                    this.$toast.success('Promocion entregada correctamente');
                    this.loading_generar = false; 

                    this.form.productos = null
                    this.form.PromoDisponibles = null
                    this.form.clientecanje  = null
                    this.TotalReclamar = null
                }
            } catch (error) {
                console.log(error)
            }
            

           
        },
        async getdata(){
            this.loading = true;
            this.recordsProductos = null 
           
            try {
                const obtenerClientes = await axios.get(`pos/showCliePromos`) 
                let {status, data} =  obtenerClientes
                if(status == 200) {
                    console.log(obtenerClientes.data.data)
                    this.recordsClientes = obtenerClientes.data.data;

                    this.loading = false ; 
                    

                }
                
            } catch (error) {
                console.error(error)
                this.$toast.error('Algo extraño ha ocurrido, tomar captura del incidente y enviarla a soporte');
            }
            
        },
        async getProducts(){
            this.form.PromoDisponibles = null ; 
            this.form.acumulateItems = null ; 
            this.loadingProdcutos = true;
            this.loadingHist = true ; 
            try {

                /* const obtenerProductos = await axios.post(`pos/getPrductosPromo`,{
                    id: this.form.clientecanje
                });
                const obtenerHistoricoCanje = await axios.get(`pos/HistCanje`); */
                const promesas = [
                    axios.post(`pos/getPrductosPromo`,{
                    id: this.form.clientecanje
                    }),
                    axios.post(`pos/HistCanje?page=${this.pagination.current_page}`,{
                        id: this.form.clientecanje
                    })
                ];
  
                const [obtenerProductos, obtenerHistoricoCanje] = await Promise.all(promesas.map(p => p.catch(e => e)));
                    
               
                let {status: statusProd , data: dataProd} = obtenerProductos
                let {status: statusHist , data:  dataHist} = obtenerHistoricoCanje
                console.log(obtenerHistoricoCanje)
                
                if(statusHist === 200 ){
                    console.log(dataHist);
                    this.histCambios = dataHist.data; 
                    this.loadingHist = false
                    
                    this.pagination= dataHist
                   
                }if( statusHist === 400){
                    console.log()
                    this.loadingHist = false
                }
                if(statusProd === 200 ){
                    console.log(obtenerProductos);
                    this.recordsProductos = dataProd; 
                    this.loadingProdcutos = false
                   
                }if( statusProd === 400){
                    console.log()
                    this.loadingProdcutos = false
                }
            } catch (error) {
                console.log(error)
                this.loadingProdcutos = false
                this.loadingHist = false
            }
        },
        cantidadDisponible(){
            console.log(this.recordsProductos.find((m) => m.id === this.form.productos ))
            const records   = this.recordsProductos.find((m) => m.id === this.form.productos )
            this.form.acumulateItems = records.prom_cumulative_purchase
            this.form.PromoDisponibles  = records.prom_to_redeem
            this.form.promotion_count = records.promotion_count
            

        }
       
    }
};
</script>
