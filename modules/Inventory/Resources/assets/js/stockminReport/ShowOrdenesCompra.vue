<template>
    <el-dialog  :visible="showdialogOrdenesCompra" append-to-body  @close="close" width="60%"    @open="open"
        title="Listado de Ordenes de Compra ">
        <div >
            <div class="container container table-responsive col-md-12" v-loading="loadingverListOrdenCom">
                <table class="table table-hover table-striped table-condensed  table-responsive"   style="width:100%;     white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>N orden </th>
                            <th>Productos</th>
                            <th>Fecha</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, idx)  in listOrdenCompra " :key="idx" >
                            <td><el-button :loading="loading_ordCompras" type="info" size="small" @click="genExcel(data.id)"><i class="fas fa-print"></i></el-button>
                            </td>
                            <td>Orden N {{ data.id }}</td>
                            
                            <td>
                                <el-popover
                                
                                placement="right"
                                width="400"
                                trigger="click">
                                <el-table  v-if="ojoactivo" :data="detailOrden" v-loading="!ojoactivo">
                                    <el-table-column width="80" property="key" label="#"></el-table-column>
                                    <el-table-column width="220" property="description" label="Producto"></el-table-column>
                                    <el-table-column width="220" property="name" label="Proveedor"></el-table-column>
                                    
                                </el-table>
                                <el-button @click="openeye(data.id)" slot="reference"> <i class="fa fa-eye"></i></el-button>
                            </el-popover> </td>
                            <td>{{data.created_at}}</td>
                        </tr>
                        
                    </tbody>
                </table>
                <el-pagination
                                @current-change="getListOrdenCompra(true)"
                                
                                layout="total, prev, pager, next"
                                :total="pagination.total"
                                :current-page.sync="pagination.current_page"
                                :page-size="pagination.per_page">
                        </el-pagination>
            </div>
            
        </div>
        
        <span slot="footer">
            <el-button  :loading="loading_generar"  @click="exportExcel" class="btn bg-primary">Generar Orden</el-button>
                
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showdialogOrdenesCompra"],
    data() {
        return {
            resource: 'reports/stockmin',
            loadingverListOrdenCom: false,
            listOrdenCompra: [],
            loading_ordCompras: false,
            loading_generar: false,
            pagination: {},
            ojoactivo: false,
            detailOrden: []

        }
    },
    methods: {
        async open(){
            this.loadingverListOrdenCom = true 
            this.getListOrdenCompra();
        },
        close(){
            this.$emit("update:showdialogOrdenesCompra", false);
        },
        exportExcel(id){
            window.open(
                `/${this.resource}/exportExcel`,
                "_blank"
            );
        },
        async  getListOrdenCompra(nextpage){
            let url = ''
            try {
                if(nextpage== true){
                                        
                    let newPage = this.pagination.current_page 
                    console.log('nueva pagina ', newPage)
                    console.log("estamos buscando la url con una pagina nueva ");
                    url = `/${this.resource}/listOrdenCompra?page=${newPage}`
                    
                }else{
                    url = `/${this.resource}/listOrdenCompra`
                }

                const response = await this.$http.get(url);
                const { status ,data} = response;
                
                if(status == 200) {
                    this.listOrdenCompra = data.data
                    console.log(response)
                    this.pagination = data
                    
                   
                }else{
                    console.log(response)
                }
            } catch (error) {
                this.$toast.error(error.message)
            }finally{
                this.loadingverListOrdenCom = false
            }
        },
         genExcel(id){
             
             window.open(
                `/${this.resource}/exportExcel/${id}`,
                "_blank"
            );
            
        },
       async openeye(id){
                this.ojoactivo =false;
                
                try {
                const response = await this.$http.get(`/${this.resource}/productosDetalle/${id}`);

                const { status ,data} = response;
                
                if(status == 200) {
                  this.detailOrden = data
                   
                   this.ojoactivo = true 
                    
                }else{
                    console.log(response)
                }
                } catch (error) {
                    this.$toast.error(error.message)
                }
        },
        nextpage(){
            console.log('buscando siguiente pagina ');
            this.getListOrdenCompra(true)
        }

    }
}
</script>