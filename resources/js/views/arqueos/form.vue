<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create();" :show-close="false" :close-on-click-modal="false">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                             <div class="col-md-12">
                                <label class="control-label w-100">Monedas</label>
                            </div>
                            <div class="col-md-4 text-left">
                                <label class="control-label w-100">0.10</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number class="w-100" v-model="form.diez_moneda" :precision="0" :controls="false" size="mini" @change="sumar_monedas()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                 <label class="control-label w-100">0.20</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.veinte_moneda" :precision="0" :controls="false" size="mini" @change="sumar_monedas()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                <label class="control-label w-100">0.50</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.cincuenta_moneda" :precision="0" :controls="false" size="mini" @change="sumar_monedas()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                  <label class="control-label w-100">1.00</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.uno_moneda" :precision="0" :controls="false" size="mini" @change="sumar_monedas()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                <label class="control-label w-100">2.00</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.dos_moneda" :precision="0" :controls="false" size="mini" @change="sumar_monedas()"></el-input-number>
                            </div>
                            <div class="col-md-4 text-left">
                                <label class="control-label ">5.00</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.cinco_moneda" :precision="0" :controls="false" size="mini" @change="sumar_monedas()"></el-input-number>
                            </div>
                           

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label w-100">Biletes</label>
                            </div>
                            <div class="col-md-4 text-left">
                                  <label class="control-label w-100">10</label>
                            </div>
                            <div class="col-md-6">
                                 <el-input-number v-model="form.diez_billete" :precision="0" :controls="false" size="mini" @change="sumar_billetes()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                 <label class="control-label w-100">20</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.veinte_billete" :precision="0" :controls="false" size="mini" @change="sumar_billetes()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                 <label class="control-label w-100">50</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.cincuenta_billete" :precision="0" :controls="false" size="mini" @change="sumar_billetes()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                 <label class="control-label w-100">100</label>
                            </div>
                            <div class="col-md-6">
                                 <el-input-number v-model="form.cien_billete" :precision="0" :controls="false" size="mini" @change="sumar_billetes()"></el-input-number>
                            </div>
                             <div class="col-md-4 text-left">
                                  <label class="control-label w-100">200</label>
                            </div>
                            <div class="col-md-6">
                                <el-input-number v-model="form.docientos_billete" :precision="0" :controls="false" size="mini" @change="sumar_billetes()"></el-input-number>
                            </div>
                            
                            <div class="col-md-12" style="height:35px !important;">
                                 
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class= "col-md-4">
                   <div class="row">  
                          <div class="col-md-12">
                                <b>Resumen</b>
                            </div>
                        <div class="col-md-12 text-md-left">
                                  <label class="control-label text-left">Fecha Ventas</label>
                                   <el-date-picker  v-model="fecha"  type="date" @change="changeBox"  value-format="yyyy-MM-dd" format="dd-MM-yyyy">
                             </el-date-picker>
                        </div>
                          <div class="col-md-12 text-md-left">
                                  <label class="control-label text-left">Fecha Cierre Caja</label>
                                   <el-date-picker  v-model="form.fecha"  type="date" value-format="yyyy-MM-dd" format="dd-MM-yyyy">
                             </el-date-picker>
                        </div>
 
                          <div class="col-md-6 text-end">
                         <label class="control-label text-primary">Apertura Caja </label>
                        </div>
                        <div class="col-md-6  text-primary text-end">
                            <b>S/ {{form.apertura}}</b>
                        </div>

                        <div class="col-md-6 text-end">
                         <label class="control-label text-primary">Total Venta </label>
                        </div>
                        <div class="col-md-6  text-primary  text-end">
                            <b>S/{{form.total_sistema}}</b>
                        </div>
                       
                         <div class="col-md-6 text-end  text-end">
                            <label class="control-label text-danger">Gastos </label>
                        </div>
                        <div class="col-md-6 text-danger  text-end">
                            <b class="text-danger">S/ {{form.egresos}}</b>
                        </div> 
                        <div class="col-md-6 text-end">
                            <label class="control-label text-primary">Saldo Efectivo </label>
                        </div>
                        <div class="col-md-6 text-md-left text-primary text-end">
                           <b>S/ {{form.total}}</b>
                        </div>
                           <div class="col-md-6 text-end">
                            <label class="control-label text-primary">Diferencia </label>
                        </div>
                        <div class="col-md-6 text-md-left text-primary  text-end">
                           <b>S/ {{diferencia}}</b>
                        </div>
                   </div>
                </div>
                </div>
            <div class="row">
                <div class="col-md-4 text-end">
                     <label class="control-label w-100"><b>Total Moneda S/</b></label>   {{form.total_moneda}}
                </div>
                <div class="col-md-4 text-end">
                    <label class="control-label w-100"><b>Total Billete S/</b></label>  {{form.total_billete}}
                </div>
                  <div class="col-md-4 text-end">
                     <label class="control-label w-100">Total S/</label>  <b>{{form.efectivo_total}}</b>
                </div>
            </div>
              <hr>
                  <div class="row">
                <div class="col-md-8 text-md-left">
                      <el-radio-group v-model="form.transferir">
                    <el-radio :label="0">No transferir Caja</el-radio>
                    <el-radio :label="1">Transferir Caja</el-radio>

                     </el-radio-group>
                </div>
                <div class="col-md-12 text-md-left">
                    <label class="control-label w-100"><b>Transferir</b></label> 
                       <el-input type="textarea" v-model="form.transferir_a" :precision="0" :controls="false" size="mini"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                </div>
                
            </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>
    </el-dialog>

</template>

<script>
import moment from 'moment';
import _ from 'lodash';
    import {functions} from '../../mixins/functions'

    export default {
        mixins: [functions],
        props: ['showDialog', 'recordId'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'arqueos', // nombre tabla
                form:{},
                errors: {},
                imageUrl:false,
                fecha:moment().format('YYYY-MM-DD'),
                showDialogNewPerson:false,
                input_person:false,
                titleDialog:'Lista de Arqueo de Caja',
                array_establecimiento:[],
                diferencia:0.00
              
            }
        },
        async created() {
             await  this.initForm()
            
        },

        methods: {

        initForm() {
            this.errors = {}
            this.form = {
            diez_moneda:0,   
            veinte_moneda:0,  
            cincuenta_moneda:0, 
            uno_moneda:0, 
            dos_moneda:0,  
            cinco_moneda:0, 
            diez_billete:0, 
            veinte_billete:0, 
            cincuenta_billete:0, 
            cien_billete:0, 
            docientos_billete:0,
            fecha:moment().format('YYYY-MM-DD'), 
            total_sistema:0.00, 
            egresos:0.00, 
            efectivo_total:0.00, 
            establishment_id:1,
            total_billete:0.00,
            total_moneda:0.00,
            total:0.00,
            apertura:0.00,
            state:"1",
            transferir:0.00,
            transferir_a:"",
            }
        },
        async changeBox(){
             this.form.fecha=this.fecha
             await this.$http.get(`/${this.resource}/tables?fecha=`+this.fecha)
                    .then(response => {     
                       this.form.establishment_id = response.data.establecimiento.id;
                         let egresos=response.data.egresos_total
                        let total_sistema=response.data.total_sistema
                        this.form.egresos=egresos.toFixed(2)
                        this.form.total_sistema=total_sistema.toFixed(2)
                        this.form.apertura=response.data.apertura;
                    })
             this.totales_efectivos()
        },
        async create() {
            
            this.initForm()
            this.titleDialog = (this.recordId)? 'Editar Cierre de Caja':'Registrar Cierre de Caja'
            if (this.recordId) {
                await this.$http.get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => { 
                        if (response.data !== '') {
                            this.form = response.data.data
                         
                        }
                        
                    })
            
            }else{
               await this.changeBox()
               this.totales_efectivos()
            }
              this.totales_efectivos()
            
        
        },
        submit() {
            this.loading_submit = true
            this.$http.post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message)
                        this.$eventHub.$emit('reloadData')
                        //location.reload();
                        this.close()
                    } else {
                        this.$toast.error(response.data.message)
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data
                    } else {
                        console.log(error)
                    }
                })
                .then(() => {
                    this.loading_submit = false
                })
        },
        sumar_monedas(){
            let diez=_.round(this.form.diez_moneda *0.10,2)
            let veinte_centavos=_.round(this.form.veinte_moneda*0.20,2)
            let cicuenta=(this.form.cincuenta_moneda)*0.50
            let unsol=(this.form.uno_moneda)*1
            let dossol=(this.form.dos_moneda)*2
            let cinco=(this.form.cinco_moneda)*5
            let total=diez+veinte_centavos+cicuenta+unsol+dossol+cinco
            this.form.total_moneda=total.toFixed(2)
             this.totales_efectivos()
        },
        sumar_billetes(){
            let billeteDiez=this.form.diez_billete*10
            let billeteViente=this.form.veinte_billete*20
            let billeteCincuenta=this.form.cincuenta_billete*50
            let billeteCien=this.form.cien_billete*100
            let billeteDoscientos=this.form.docientos_billete*200
            let total_billete=billeteDiez+billeteViente+billeteCincuenta+billeteCien+billeteDoscientos
            this.form.total_billete=total_billete.toFixed(2)
            this.totales_efectivos()
        },
         totales_efectivos(){
             
             let result=parseFloat( this.form.total_moneda)+parseFloat(this.form.total_billete)
             let total=(parseFloat(this.form.total_sistema)-parseFloat(this.form.egresos))+parseFloat(this.form.apertura)
             this.form.total=total.toFixed(2)
             console.log(total.toFixed(2))
             this.form.efectivo_total=result.toFixed(2)
         
             this.diferencia=total-this.form.efectivo_total
             this.diferencia=this.diferencia.toFixed(2)
         },
        close() {
            this.$emit('update:showDialog', false)
            this.initForm()
        },
        }
    }
</script>
