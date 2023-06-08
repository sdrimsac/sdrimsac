<template>
    <el-dialog  :visible="showNuevoUtil" append-to-body @close="close"  width="60%"  
        title="Nuevo Util">
        <div >
            <div class="row col-md-12 " style="  margin-top: 20px;">
                <div class="col-md-4">
                    <label class="control-label">Nombre del Util</label> 
                            <el-input v-model="form.inputName" @input="searchNamesSupplies" placeholder="Ingrese Nombre del Util Escolar" size="small" ></el-input>
                           <div >
                               
                                    <el-tag size="mini" v-for="item in showliNames" :key="item.s_supp_id" :value="item.s_supp_id" v-html="item.s_supp_name"></el-tag >
                                
                           </div>
                               
                </div>
                <div class="col-md-4">
                    <label >Codigo del Articulo Escolar</label>
                    <el-input v-model="form.codigo" @input="searchCodeSupplies" placeholder="Ingrese el codigo del articulo" size="small" ></el-input>
                    <div >
                        <el-tag size="mini" v-for="item in showCodeDiv" :key="item.s_supp_id" :value="item.s_supp_id" v-html="item.s_supp_codigo"></el-tag >
                      </div>
                    
                </div>
                <div class="col-md-4">
                    <label class="control-label">Marca <a
                                    href="#"
                                    @click.prevent="shownewBranch = true"
                                    >[+ Nuevo]</a
                                ></label>
                        <el-select
                                v-model="form.item_id"
                                @change="changeBranch"
                                filterable
                            >
                                <el-option
                                    v-for="option in branchsupplies"
                                    :key="option.brnd_supp_id"
                                    :value="option.brnd_supp_id"
                                    :label="option.brnd_supp_name.toUpperCase()"
                                ></el-option>
                            </el-select>
                </div>
            </div>
            <div class="row col-md-12">
                
            </div>
        </div>
        <span slot="footer">
            <el-button @click="close">Cancel</el-button>
            <el-button :loading="loadsavesuplie" @click="SaveSupplie" class="btn btn-primary">Guardar</el-button>
            
        </span>
        <el-dialog
        append-to-body
            title="Nueva Marca"
            :visible.sync="shownewBranch"
            width="30%"
            @close="shownewBranch = false">
            <span></span>
            <el-input v-model="newBranch" placeholder="Ingrese marca nueva" size="small" ></el-input>
            
            <span slot="footer">
                <el-button @click=" shownewBranch = false">Cancel</el-button>
                <el-button :loading="marcabutonloading" type="primary" @click="saveNewBranch()">Guardar</el-button>
            </span>
        </el-dialog>
        
    </el-dialog>
</template>

<script>


export default ({
    props: ["showNuevoUtil", 'branchsupplies'],
    
    data(){
        return {
            resource: 'listsuplies',
            form:{item_id: ''},
           
            shownewBranch: false ,
            newBranch: '',
            nameSupplies: [],
            showdropnames: false ,
            showliNames: [],
            showCodeDiv:[],
            source: null,
            loadsavesuplie: false ,
            marcabutonloading: false


        }
    }, 
    methods: {
        close(){
            this.$emit("update:showNuevoUtil", false);
        },
        changeBranch(){
            
        },
        async saveNewBranch(){
            this.marcabutonloading = true 
            try {
                const response = await axios.post(`${this.resource}/saveNewBranch`,{
                    nombre: this.newBranch
                })  ;
                const {message, status,data  } = response ;
                if (status == 200){
                    console.log(response)
                    //this.branchSupplies = data
                    const filtro = data.filter(name => name.brnd_supp_name === this.newBranch)
                    console.log(filtro)
                    this.form.item_id = filtro[0].brnd_supp_id;
                    this.$emit("update:branchsupplies", data);
                    console.log(this.form)
                    this.$toast.success('Marcar Agregada correctamente ');
                    this.shownewBranch = false
                }
            } catch (error) {
                console.log(error.response.data)
                this.$toast.error(error.response.data.error)
            }finally{
                this.marcabutonloading = false 
            }
        },
        async SaveSupplie(){
            this.loadsavesuplie = true 
            if(this.form.inputName != '' && this.form.codigo != '' && this.form.item_id != '' ){
                try {
                    const response = await axios.post(`${this.resource}/saveSupplie`,{
                    inputName: this.form.inputName,
                    codigo: this.form.codigo,
                    item_id: this.form.item_id

                    });
                    const {status, data } = response 
                    if (status == 200) {
                        console.log(data)
                        this.$toast.success('Datos guardados correctamente ')

                        this.$emit("update:showNuevoUtil", false)

                    }
                } catch (error) {
                    console.log(error)
                    this.$toast.error(error.response.data.error)
                }finally{
                    this.loadsavesuplie = false 
                }
            }else{
                this.$toast.warning('Recuerde rellenar todos los campos ');
                this.loadsavesuplie = false 
            }

        },
        async searchNamesSupplies(input){
            if(this.source){
                    this.source.cancel('La petición fue cancelada por el usuario');
                }
            if(input.length > 2 && input !=''){
                this.source = axios.CancelToken.source();
                try {
                    const response = await axios.post(`${this.resource}/searchnameSupplies`,{
                        input

                    },{cancelToken: this.source.token});

                    const {data, status } = response 
                    
                    if(status == 200) {
                        
                         this.showliNames = data.resultado;
                    }
                    
                } catch (error) {
                    console.log(error)
                }
            }else{
                this.showliNames = '';
            }
            
        },
        async searchCodeSupplies(input){
            
            if(this.source){
                    this.source.cancel('La petición fue cancelada por el usuario');
                }
            if(input.length > 2 && input !=''){
                
                this.source = axios.CancelToken.source();
                try {
                    const response = await axios.post(`${this.resource}/searchCodeSupplies`,{  input,
                        
                    },{cancelToken: this.source.token});

                    const {data, status } = response 
                    
                    if(status == 200) {
                         this.showCodeDiv = data.resultado;
                         
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
        }
    },
})
</script>
