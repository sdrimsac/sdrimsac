<template>
    <el-dialog  :visible="showOrdenCompraMasiva" append-to-body @close="close"  width="60%"  @open="open"
        title="Generar orden de compra ">
        <div >
            <div class="container container table-responsive col-md-12" v-loading="loadingGenOrdenCom">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <h3 class=" text-muted ">
                            Buscar
                        </h3>

                        <el-select v-model="input_searchItems"  placeholder="Seleccionar Proveedor " clearable filterable >
                            <el-option v-for="item in recordProv"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                        
                    </div>
                </div>
            </div>
            
        </div>
        
        <span slot="footer">
            <el-button  :loading="loading_generar" @click="generarOrdenMasiva()" class="btn bg-primary">Generar Orden Masiva </el-button>
                
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showOrdenCompraMasiva"],
    data() {
        return {
            resource: 'reports/stockmin',
            loadingGenOrdenCom: false,
            ordenesCompra: [],
            loading_submit: false,
            loading_generar: false,
            input_searchItems : "" ,
            recordProv : [],

        }
    },
    methods: {
        async open(){
            this.loadingGenOrdenCom = true 
            this.getListProv();
        },
        close() {
            this.$emit("update:showOrdenCompraMasiva", false);
        },
        async getListProv(){

            console.log('getListProv')
            try {
                const response = await axios.get(`/${this.resource}/getListProv`);

                const { status ,data} = response;
                console.log(data.data);
                if(status == 200) {
                    this.recordProv = data.data
                }else{
                    console.log(response)
                }
            } catch (error) {
                this.$toast.error(error.message)
            }finally{
                this.loadingGenOrdenCom = false
            }
        },
        
        async generarOrdenMasiva(){
            if(this.input_searchItems === '' || this.input_searchItems == null ){
                this.$toast.warning('Seleccione un Proveedor antes de continuar');
                return 
            }
            try {
                
                const response = await axios.post(`/${this.resource}/genOrdenCompraMasiva`,{
                    prov_id: this.input_searchItems
                }
                );

                const { status ,data} = response;
                if(status == 200) {
                     console.log(response)
                  let id = data;
                    window.open(
                        `/${this.resource}/exportExcel/${id}`,
                        "_blank"
                    );
                    this.$toast.success('Orden generada Satisfactoriamente ');
                    this.$emit('callBrotherMethod');
                }
            } catch (error) {
                console.log(error)
                this.$toast.error(error.response.data.error)
            }finally{
                this.loading_generar = false 
                this.input_searchItems = ""
                this.close();
                
            }
            
        }
    }
}
</script>