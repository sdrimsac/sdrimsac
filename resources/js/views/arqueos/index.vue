<template>
    <div>
 
    <div class="container-fluid p-l-0 p-r-0">
                <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                    <h6><span>Comprobantes</span></h6>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><span class="text-muted">Arqueo de Caja</span></li>
                    </ol>
                    </div>
                    <div class="col-sm-6">
                    <div class="bookmark">
                    <ul>
                        <li>
                            <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                                <a href="javascript:void(0)" @click.prevent="clickCreate()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                    <i data-feather="plus-circle"></i>
                                </a>
                            </el-tooltip>
                        </li>
                        <li>
                            <el-tooltip class="item" effect="dark" content="Apertura" placement="bottom-end">
                                <a href="javascript:void(0)" @click.prevent="clickApertura()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                    <i data-feather="dollar-sign"></i>
                                </a>
                            </el-tooltip>
                        </li>
                        </ul>
                    </div>
                    <!-- Bookmark Ends-->
                    </div>
                </div>
                </div>
    </div>
          <!-- Container-fluid starts-->
    <div class="container-fluid p-l-0 p-r-0">        
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Registro de Arqueo de Caja</h6>
            </div>
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-left">Fecha</th>
                        <th class="text-left">Egresos</th>
                        <th class="text-center">Total Sistema</th>
                        <th class="text-center">Total Efectivo</th>
                        <th class="text-center">Saldo Efectivo</th>
                        <th class="text-left">Efectivo Transferido</th>
                        <th class="text-left">Transferido a </th>

                        <th class="text-center">Estado</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    
                        <tr slot-scope="{ index, row }">
                            <td  class="text-left">{{ index + 1 }}</td>
                            <td class="text-left">{{row.fecha }}</td>
                            <td class="text-center">{{ row.egresos }}</td>
                            <td class="text-center">{{ row.total_sistema }}</td>
                            <td class="text-center">{{ row.efectivo_total }}</td>
                            <td class="text-center">{{ row.total}}</td>
                        <template v-if="row.transferir">
                                <td class="text-center">SI</td>
                        </template>
                        <template v-else>
                                <td class="text-center">No</td>
                        </template>
                            <td class="text-center">{{row.transferir_a}}</td>
                            <template v-if="row.state=='1'">
                                <td class="text-center">Caja Apertura</td>
                            </template>
                            <template  v-if="row.state=='0'">
                                <td class="text-center">Caja Cerrada</td>
                            </template>

                            <td class="text-end">
                                <template v-if="hoy==row.fecha">
                            <!--
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-danger btn-sm" @click.prevent="clickCerrar(row.id)"  v-if="row.state=='0'">Cerrar Caja</button>
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-primary btn-sm" @click.prevent="clickAbrir(row.id)"  v-if="row.state=='1'">Reabrir Caja</button>
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-info btn-sm" @click.prevent="clickCreate(row.id)">Editar</button>
                                -->
                                </template>
                            </td>
                        </tr>
                </data-table>
            </div>
            <ArqueoForm :showDialog.sync="showDialog" :recordId.sync="recordId" :loading_submit.sync="loading_submit"></ArqueoForm>


        </div>
    </div>
    </div>
</template>
<script>

    import moment from 'moment';
    import ArqueoForm from './form.vue'
    import DataTable from '../../components/DataTable.vue'
    import {deletable} from '../../mixins/deletable'
    export default {
        mixins: [deletable],
        components: {ArqueoForm, DataTable},
        data() {
            return {
                title: null,
                showDialog: false,
                showImportDialog: false,
                showExportDialog: false,
                resource: 'arqueos',
                recordId: null,
                loading_submit: false,
                hoy:moment().format('DD-MM-YYYY'), 
                form_apertura:{},
                apertura:false,
                caja_cerrada:false
            }
        },
        created() {
            this.title = 'Caja'
            this.$http.get(`/${this.resource}/apertura`)
                        .then(res => {
                        // if(res.data.apertura==true){
                             this.apertura=res.data.apertura
                             this.caja_cerrada=res.data.caja_cerrada
                        //}

                    })
        },
        methods: {
            clickCreate(recordId = 0) {
                if(recordId != 0 || recordId != null){
                        this.recordId = recordId
                        this.showDialog = true
                        this.loading_submit-=true
                }else{
                    this.$http.get(`/${this.resource}/statusarqueo`)
                        .then(res => {
                         if(res.data.status_caja==true){
                              this.$toast.error("Cierre de Caja Pendiente")
                        }
                    })
                }
                     
                
            },
            clickImport() {
                this.showImportDialog = true
            },
            clickExport() {
                this.showExportDialog = true
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
            clickApertura(){
                 this.form_apertura = {
                    id: null,
                    user_id: 1,
                    date_opening: moment().format('YYYY-MM-DD'),
                    time_opening: null,
                    date_closed: null,
                    time_closed: null,
                    beginning_balance: 0,
                    final_balance: 0,
                    income: 0, 
                    state: true,
                    reference_number: null
                }

                this.$confirm('¿Desea Aperturar la Caja con Monto Cero?', 'Aviso', {
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
                    this.$http.post(`/cash`,this.form_apertura)
                        .then(res => {
                            if(res.data.success) {
                                location.reload();
                                this.$toast.success(res.data.message)
                                    this.$eventHub.$emit('reloadData')
                            }else{
                                this.$toast.error(res.data.message)
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 500) {
                                this.$toast.error('Error al intentar habilitar');
                            } else {
                                console.log(error.response.data.message)
                            }
                        })
                }).catch(error => {
                    console.log(error)
                });
            },
            clickCerrar(id){
                this.$confirm('¿Desea cerrar la Caja?', 'Habilitar', {
                    confirmButtonText: 'Cerrar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
                    this.$http.put(`/${this.resource}/deshabilitar/${id}`)
                        .then(res => {
                            if(res.data.success) {
                                location.reload();
                                this.$toast.success(res.data.message)
                                    this.$eventHub.$emit('reloadData')
                            }else{
                                this.$toast.error(res.data.message)
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 500) {
                                this.$toast.error('Error al intentar habilitar');
                            } else {
                                console.log(error.response.data.message)
                            }
                        })
                }).catch(error => {
                    console.log(error)
                });
            },
            clickAbrir(id){
                this.$confirm('¿Desea habilitar la Caja?', 'Aviso', {
                    confirmButtonText: 'Habilitar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning'
                }).then(() => {
                    this.$http.put(`/${this.resource}/habilitar/${id}`)
                        .then(res => {
                            if(res.data.success) {
                                location.reload();
                                this.$toast.success(res.data.message)
                                    this.$eventHub.$emit('reloadData')
                            }else{
                                this.$toast.error(res.data.message)
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 500) {
                                this.$toast.error('Error al intentar habilitar');
                            } else {
                                console.log(error.response.data.message)
                            }
                        })
                }).catch(error => {
                    console.log(error)
                });
            },
            clickDisable(id){
                this.disable(`/${this.resource}/enabled/${0}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
            clickEnable(id){
                this.enable(`/${this.resource}/enabled/${1}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
        }
    }
</script>