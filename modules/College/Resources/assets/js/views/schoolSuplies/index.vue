<template>
  <div>
    <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Listado de Utiles Escolares </span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Suscripcion Escolar </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Almacen de Utiles</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Listado de utiles en el almacen  </h6>
            </div>
            <div class="card-body">
                <div class="col-md-12 col-lg-12 col-xl-12 ">
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> </label>
                                    <el-button type="primary" size="small" @click="changeNuevoUtil">
                                        Nuevo Util Escolar
                                    </el-button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> </label>
                                    <el-button type="primary" size="small" @click="changeingresarUtil">
                                        Ingresar Util Escolar
                                    </el-button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> </label>
                                    <el-button type="primary" size="small" @click="changeSacarUtil">
                                        Sacar Util Escolar
                                    </el-button>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12">
                        <datatable  ref="dataTable" :salones="salones">
                            <tr slot="heading">
                                    <th>#</th>
                                    <th >Acciones</th>
                                    <th>Nombre del Util  </th>
                                    <th>Codigo Unico </th>
                                    <th class="text-end">Salon al que Pertenece  </th>
                                    <th class="text-end">Stock en Almacen </th>
                                    
                                    
                                </tr>

                                <tr></tr>
                                <tr slot-scope="{ index, row }"
                                
                                >
                                    <td>{{ index }}</td>
                                    <td >
                                        
                                        <button 
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-info"
                                                @click.prevent="acccionDetail(row.list_supp_id)"
                                            >
                                                Detalle
                                        </button>
                                        
                                       
                                    </td>
                                    <td>{{ row.s_supp_name }}</td>
                                    <td>{{ row.s_supp_codigo }}</td>
                                    <td class="text-end ">{{ `${row.grade_desc} ${row.nivel_desc} Sec: ${row.sections_desc} `}}</td>
                                    <td class="text-end " >{{ row.list_supp_cantidad }}</td>
                                    
                                </tr>
                        </datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nuevoUtil
        :showNuevoUtil.sync="showNuevoUtil"
        :branchsupplies.sync="branchsupplies"
    ></nuevoUtil>
    <ingresarUtil
        @callBrotherMethod="callMethod"
        :showingresarUtil.sync="showingresarUtil">
    </ingresarUtil>
    <sacarUtil
        @callBrotherMethod="callMethod"
        :showSacarUtil.sync="showSacarUtil">
    </sacarUtil>
    <detalleAlmacen
        :idListSupplies.sync = "idListSupplies"
        :showDetalledialog.sync="showDetalledialog"
    >

    </detalleAlmacen>
    

  </div>
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
const nuevoUtil = () => import(/* webpackChunkName:"js/nuevoUtil.vue"*/ "./nuevoUtil.vue");
const ingresarUtil = () => import(/* webpackChunkName:"js/ingresarUtil.vue"*/"./ingresarUtil.vue");
const sacarUtil = () => import(/* webpackChunkName:"js/sacarUtil.vue"*/"./sacarUtil.vue");
const datatable = () => import(/* webpackChunkName:"js/tablelistSupplie.vue"*/"./tablelistSupplie.vue");
const detalleAlmacen = () => import(/* webpackChunkName:"js/tablelistSupplie.vue"*/"./detalleAlmacen.vue");

export default {
    props: ["configuration", "branchsupplies", "salones"],
    components: {nuevoUtil,ingresarUtil,sacarUtil,datatable,detalleAlmacen},
    data(){
        return{
            showNuevoUtil: false,
            showingresarUtil: false,
            showSacarUtil: false,
            resource: '',
            showDetalledialog: false, 
            idListSupplies: null 
        }
    }, 
    methods: {
        changeNuevoUtil(){
            this.showNuevoUtil = true;
        },
        changeingresarUtil(){
            this.showingresarUtil = true;
        },
        changeSacarUtil(){
            this.showSacarUtil = true;
        },
        acccionDetail(id_detail){
            this.showDetalledialog = true; 
            
            this.idListSupplies = id_detail ; 
        },
        callMethod(){
            
            this.$refs.dataTable.getRecords();
        }
    },
    mounted(){
        //console.log(this.branchSupplies);
        
    }

}
</script>