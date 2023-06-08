<template>
  <el-dialog append-to-body
    @open="open"
    title="Detalle de Utiles del almacen "
    :visible.sync="showDetalledialog"
    width="50%"
    @close="close">
    <div class = row col-12>
        <h2>Listado de alumnos</h2>

        <div class="col-md-3">
            <span>  Stock total: <b>{{cantidadStock}}</b> </span>
        </div>

        <div class="col-md-12" v-loading="loadingtableRecords">
            <div class="row">
                <el-pagination
                        @current-change="getRecords"
                        layout="total, prev, pager, next"
                        :total="pagination.total"
                        :current-page.sync="pagination.current_page"
                        :page-size="pagination.per_page">
                </el-pagination>
            </div>
            <div class="table-responsive">
                    <table class="table table table-striped table-hover" style="width:100%;     white-space: nowrap;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Persona </th>
                            <th>Fecha </th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Observacion</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, idx)  in listAlumnosUtiles " :key="idx">
                           
                            <td>{{ idx + 1 }}</td>
                            <td>{{ data.name }}</td>
                            <td>{{ data.crate_at_mov_kardex }}</td>
                            <td v-if="data.k_supp_id_type_event == 1 ">{{ Number(data.k_supp_cantidad).toFixed(2) }}</td>
                            <td v-if="data.k_supp_id_type_event == 1 "></td>
                            <td v-if="data.k_supp_id_type_event == 2 "></td>
                            <td v-if="data.k_supp_id_type_event == 2 " >{{ Number(data.k_supp_cantidad).toFixed(2) }}</td>
                            <td >{{ data.k_supp_DescMovimiento}}</td>
                            
                        </tr>
                    </tbody>
                    </table>
                    
                </div>
        </div>
    </div>
    
    <span slot="footer">
        <el-button @click="close()">Cancel</el-button>
        <el-button type="primary" @click="close()">OK</el-button>
    </span>
  </el-dialog>
  
</template>

<script>
export default {

    props: ["showDetalledialog","idListSupplies"],
    data() {
        return {
            listAlumnosUtiles: [],
            loadingtableRecords: false,
            resource: 'listsuplies',
            cantidadStock: null , 
            pagination: {},

        }
    },
    methods: {
        async open(){
            this.loadingtableRecords = true 
            this.getRecords();

        },
        close(){
            this.cantidadStock = '';
            this.$emit("update:showDetalledialog", false);
        },
        async  getRecords(){
            console.log(this.idListSupplies)
            try{
                const response = await axios.post(`${this.resource}/getDetailSupplies?page=${this.pagination.current_page}`,{
                    idListSupplies: this.idListSupplies
                });
                const {data, status } = response 
                    console.log(data)
                    if(status == 200) {
                        

                        this.listAlumnosUtiles = [...data.data.map(s =>{
                            const fechaHora = s.created_at 
                            const fechaFormat = new Date(fechaHora).toLocaleString("es-ES", {
                                                day: "numeric",
                                                month: "numeric",
                                                year: "numeric",
                                                hour: "numeric",
                                                minute: "numeric",
                                                second: "numeric",
                                                });
                            s.created_at = fechaFormat
                             
                            return {
                             ...s              
                              };
                    })];
                        
                        this.loadingtableRecords = false 
                        this.pagination= data
                        this.cantidadStock =  data.data[0].list_supp_cantidad;


                         
                    }

            } catch(error){
                console.log(error);
            }
        }
    }
}
</script>

<style>

</style>