<template>
    <el-dialog  :visible="showingresarUtil" append-to-body @close="close"  width="60%"  
        title="Ingresar Util  ">
        <div >
            <div class="row col-md-12">
                <div class="col-md-4">
                    <label class="control-label">Nombre del Util</label> 
                    <el-select
                        v-model="form.util"
                        
                        filterable
                        remote
                        :remote-method="searchRemoteUtil"
                    >
                        <el-option
                            v-for="option in SuppliesItems"
                            :key="option.s_supp_id"
                            :value="option.s_supp_id"
                            :label="option.s_supp_name.toUpperCase()"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Alumno</label> 
                    <el-select
                        v-model="form.alumn"
                        
                        filterable
                        remote
                        :remote-method="searchRemoteAlumno"
                    >
                        <el-option
                            v-for="option in ListAlumns"
                            :key="option.college_students_id"
                            :value="option.college_students_id"
                            :label="option.name.toUpperCase()"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label class="control-label">cantidad </label>
                    <el-input v-model="form.cantidad" placeholder="123"  ></el-input>
                </div>
                
            </div>
            <div class="row col-md-12">
                
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                
            </div>
        </div>
        <span slot="footer">
            <el-button @click="close">Cancel</el-button>
            <el-button :loading="botonLoadingGuardarItem" type="primary" @click="saveIntoAlmacenUtil()">Agregar</el-button>
            
        </span>
    </el-dialog>
</template>

<script>


export default ({
    props: ["showingresarUtil"],
    
    data(){
        return {
            resource: 'listsuplies',
            showliNames: null ,
            form:{} ,
            branchsupplies:[],
            SuppliesItems:[],
            source: null,
            ListAlumns:[], 
            ListProf: [],
            botonLoadingGuardarItem: false 

        }
    }, 
    methods: {
        close(){
            this.$emit("update:showingresarUtil", false);
        },
        async searchRemoteAlumno(input){
            console.log(this.source)
            if(this.source){
                    this.source.cancel('La petición fue cancelada por el usuario');
                }
            if(input.length > 2 && input !=''){
                
                this.source = axios.CancelToken.source();
                try {
                    const response = await axios.get(`${this.resource}/searchRemotealumno`,{  
                        params:{
                            input },
                            cancelToken: this.source.token
                        
                    });

                    const {data, status } = response 
                    
                    if(status == 200) {
                         this.ListAlumns = data.resultado;
                         
                    }
                } catch (error) {
                    if(this.$http.isCancel(error)){
                    console.log(error)
                    }else{
                        console.log(error)
                    }
                    
                }
                
            }
        },
        async searchRemoteUtil(input){
            
            if(this.source){
                    this.source.cancel('La petición fue cancelada por el usuario');
                }
            if(input.length > 2 && input !=''){
                
                this.source = axios.CancelToken.source();
                try {
                    const response = await axios.get(`${this.resource}/searchRemoteUtilIng`,{  
                        params:{
                            input },
                            cancelToken: this.source.token  
                    });

                    const {data, status } = response 
                    
                    if(status == 200) {
                         this.SuppliesItems = data.resultado;
                         
                    }
                } catch (error) {
                    if(this.$http.isCancel(error)){
                    console.log(error)
                    }else{
                        console.log(error)
                    }
                    
                }
                
            }else{
                this.showCodeDiv = '';
            }
        },
        async  searchRemoteProf(input){
            console.log(this.source)
            if(this.source){
                    this.source.cancel('La petición fue cancelada por el usuario');
                }
            if(input.length > 2 && input !=''){
                
                this.source = axios.CancelToken.source();
                try {
                    const response = await axios.get(`${this.resource}/searchRemoteProf`,{  
                        params:{
                            input: input},
                            cancelToken: this.source.token
                        
                    });

                    const {data, status } = response 
                    
                    if(status == 200) {
                         this.ListProf = data.resultado;
                         
                    }
                } catch (error) {
                    if(this.$http.isCancel(error)){
                    console.log(error)
                    }else{
                        console.log(error)
                    }
                    
                }
                
            }
        },
        async saveIntoAlmacenUtil(){
            
            if(this.form.inputName != '' && this.form.codigo != '' && this.form.item_id != '' ){
                this.botonLoadingGuardarItem = true 
                try {
                        const response = await axios.post(`${this.resource}/saveIntoAlmacenUtil`,{  
                            util: this.form.util,
                            alumn:  this.form.alumn,
                            cantidad:  this.form.cantidad
                            
                        });

                        const {data, status } = response 
                        
                        if(status == 200) {
                            this.ListProf = data.resultado;
                            this.$toast.success('Util ingresado correctamente ')
                            this.$emit('callBrotherMethod');
                        }
                    } catch (error) {
                        if(this.$http.isCancel(error)){
                        console.log(error)
                        }else{
                            console.log(error)
                        }
                        
                    }finally{
                        this.botonLoadingGuardarItem = false 

                    }
            }else{
                this.$toast.warning('recuerde rellenar todos los campos ')
            }
            
        }
    }
})
</script>
