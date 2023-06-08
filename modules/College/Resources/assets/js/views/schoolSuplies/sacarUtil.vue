<template>
    <el-dialog  :visible="showSacarUtil" append-to-body @close="close" @open="open" width="60%"  
        title="Sacar Util  ">
        <div v-loading="loadingData">
            <div class="row col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Salon</label> 
                    <el-select
                        v-model="form.salon"
                        filterable
                        @change="searchListadoUtilporSalon"
                    >
                        <el-option
                            v-for="option in ListSalon"
                            :key="option.id"
                            :value="option.id"
                            :label="option.degres_desc"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-4"  v-loading="loadutiles">
                    <label class="control-label">Listado de Utilies</label> 
                    <el-select 
                        v-model="form.util"
                        filterable
                        @change="consultarCantidad">
                        <el-option
                            v-for="option in Listutiles"
                            :key="option.list_supp_id"
                            :value="option.list_supp_id"
                            :label="option.s_supp_name"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-3">
                    <label class="control-label">Cantidad Disponible </label> 
                    <el-input v-model="form.suppliesDisponibles" size="small" clearable disabled ></el-input>
                    
                    
                </div>
            </div>
            <div class="row col-12">
                <div class="col-md-4">
                    <label class="control-label">Listado de Profesores </label> 
                    <el-select
                        v-model="form.profesor"
                        filterable>
                        <el-option
                            v-for="option in ListProfesores"
                            :key="option.teach_id"
                            :value="option.teach_id"
                            :label="option.name"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-3">
                    <label class="control-label">Cantidad a Retirar  </label> 
                    <div class="input-group spinner">
                        <input type="text"
                            class="form-control text-center"
                            v-model="ToRetire"
                            v-on:keydown="validateNumber"
                             />
                        <div class="input-group-text">
                            <button type="button" class="spin-up"
                                data-spin="up"
                                @click="updateDefaultFoodQty(true)">
                                <span class="arrow"></span>
                            </button>
                            <button type="button" class="spin-down"
                                data-spin="down"
                                @click="updateDefaultFoodQty(false)">
                                <span class="arrow"></span>
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row-col-12">
                <div class="col-md-6">
                    <label for=""> Observacion</label>
                    <el-input v-model="form.observacion" placeholder="Ingresar Observacion " size="Small" clearable ></el-input>
                </div>
                
                
            </div>
            
        </div>
        <span slot="footer">
            <el-button @click="close">Cerrar</el-button>
            <el-button :loading="botonLoadingsacarItem" type="primary" @click="sacarIntoAlmacenUtil()">Guardar</el-button>

                
        </span>
    </el-dialog>
</template>

<script>


export default ({
    props: ["showSacarUtil"],
    
    data(){
        return {
            ListSalon: [],
            Listutiles:[],
            ListProfesores:[],
            form: {ToRetire: 0 },
            source: null,
            resource: 'listsuplies',
            loadingData : false, 
            loadutiles: false ,
            ToRetire: '',
            botonLoadingsacarItem: false


        }
    }, 
    watch: {ToRetire(inputValue,_){
        if(inputValue > this.form.suppliesDisponibles){
                    
                    this.ToRetire = this.form.suppliesDisponibles
                } 
    }},
    methods: {
        open(){
            this.loadingData = true 
             this.getSalones()
             
        },
        close(){
            this.$emit("update:showSacarUtil", false);
        },
        async getSalones(){
            
            try {
                const response = await this.$http.get(`${this.resource}/listadoSalones`)
                const{data , status} = response
                if(status == 200) {
                    this.ListSalon = [...data.salones.map(s =>{
                            s.degres_desc = `${s.degres_desc}  ${s.lvl_desc} ${s.sect_desc}`
                             
                            return {
                             ...s              
                              };
                    })];
                    
                    
                    this.ListProfesores = data.dataProfesores
                    
                        
                }else{
                    console.log(response)
                }
                
                
                this.loadingData = false 
            } catch (error) {
                console.log(error);
                
            }
        },
        async searchListadoUtilporSalon(item){//cada vez que eligamos un salon debe actualizar la lista de utiles que esta asociado a ese salon 
            this.form.suppliesDisponibles = null
            this.loadutiles = true 
            try {
                const response = await axios.post(`${this.resource}/utilesPorSalonDeClases`, {item})
                const{data , status} = response
                if(status == 200) {
                    this.Listutiles = data 
                    
                }else{console.log(response)}
                
            } catch (error) {
                console.log(error);
            }finally{
                this.loadutiles = false 
            }

        },
        consultarCantidad(item){
            let cantidad =  this.Listutiles.find(i => i.list_supp_id == item )
             this.form.suppliesDisponibles = cantidad.list_supp_cantidad
        },
        updateDefaultFoodQty(bool){
            if (bool) {
                if(this.form.ToRetire < this.form.suppliesDisponibles){
                    this.form.ToRetire =  Number(this.form.ToRetire) + 1;
                } else {
                    this.$toast.warning('no se puede agregar mas items')
                    this.form.ToRetire = this.form.suppliesDisponibles
                }
            }else{
                if (this.form.ToRetire > 1) {
                        this.form.ToRetire = Number(this.form.ToRetire) -1 ;
                    }
            }
            
        },
        validateNumber(evt){
            if (evt.keyCode >= 65 && evt.keyCode <=90  ) 
                {
                    evt.preventDefault();
                }  
        },
        async sacarIntoAlmacenUtil(){
            
            this.botonLoadingsacarItem = true ; 
            console.log(this.form.observacion)
            
            if(this.form.salon == undefined || this.form.util == undefined || this.form.profesor == undefined || this.ToRetire =='' || this.form.observacion == '' || this.form.observacion == undefined){
                this.$toast.warning('recuerde rellenar todos los campos ')
                this.botonLoadingsacarItem = false ; 
                return 
            }else{
                try{
                    const response = await axios.post(`${this.resource}/SacarUtilsave`, {
                        salon: this.form.salon,
                        util: this.form.util,
                        profesor: this.form.profesor,
                        cantidadRetirar:  this.ToRetire,
                        stock: this.form.suppliesDisponibles,
                        observacion: this.form.observacion
                    })
                    const {status} = response
                    if(status == 200 ){
                        this.$emit('callBrotherMethod');
                    
                        this.form.salon = ''
                        this.form.util = ''
                        this.form.profesor = ''
                        this.ToRetire = ''
                        this.form.suppliesDisponibles = ''
                        this.$toast.success('Producto retirado de Almacen Correctamente');
                    }
                    

                }catch(error){
                    console.log(error)
                    this.$toast.error(error.response.data.error)
                }finally{
                    this.botonLoadingsacarItem = false ; 
                }
            }
        }

    }
})
</script>
