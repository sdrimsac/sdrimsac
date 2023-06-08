<template>
    <el-dialog  :visible="showGenOrdenCompra" append-to-body @close="close"  width="60%"  @open="open"
        title="Generar orden de compra ">
        <div >
            <div class="container container table-responsive col-md-12" v-loading="loadingGenOrdenCom">
                <table class="table table-hover table-striped table-condensed  table-responsive"   style="width:100%;     white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, idx)  in ordenesCompra " :key="idx">
                            <td><el-button :loading="loading_submit" type="danger" size="small" @click="eliminarProdcutoLista(data.id)"><i class="fas fa-trash"></i></el-button>
                            </td>
                            <td>{{ data.description }}</td>
                            <td>{{ data.unit_price }}</td>
                            <td>{{ data.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        
        <span slot="footer">
            <el-button v-if="ordenesCompra.length  != 0 " :loading="loading_generar" @click="generarOrden()" class="btn bg-primary">Generar Orden</el-button>
                
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showGenOrdenCompra"],
    data() {
        return {
            resource: 'reports/stockmin',
            loadingGenOrdenCom: false,
            ordenesCompra: [],
            loading_submit: false,
            loading_generar: false

        }
    },
    methods: {
        async open(){
            this.loadingGenOrdenCom = true 
            this.getItemsOrdenCompra();
        },
        close() {
            this.$emit("update:showGenOrdenCompra", false);
        },
        async getItemsOrdenCompra(){
            try {
                const response = await this.$http.get(`/${this.resource}/recordsOrden`);

                const { status ,data} = response;
                if(status == 200) {
                    this.ordenesCompra = data
                }else{
                    console.log(response)
                }
            } catch (error) {
                this.$toast.error(error.message)
            }finally{
                this.loadingGenOrdenCom = false
            }
        },
        async eliminarProdcutoLista(id){
            this.loading_submit = true;
            
            try {
                const response = await this.$http.post(`/${this.resource}/deletefromlist`,{
                    id 
                });

                const {message , status } = response;
                if(status == 200) {
                    
                    this.$toast.success('Producto eliminado de la Orden de compra ');
                    this.$emit('callBrotherMethod');
                    await this.getItemsOrdenCompra();
                }else{
                    console.log(response)
                }
            } catch (error) {
                this.$toast.error(error.message)
            }finally{
                this.loading_submit = false;
            }
        },
        async generarOrden(){
            this.loading_generar = true ; 
            try {
                
                const response = await axios.post(`/${this.resource}/genOrdenCompra`,{
                    ordenesCompra: this.ordenesCompra
                }
                );

                const { status ,data} = response;
                if(status == 200) {
                     
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
                this.close();
                
            }
            
        }
    }
}
</script>