<template>
    <el-dialog
    @open="open"
    @close="close"
    :visible="showDialog"
    title="Creación de penalización"
    append-to-body
    width="500px"
    >
    <div class="row m-2">
        <div class="col-md-12">
            <label for="description">Descripción</label>
            <el-input
                v-model="form.description"
                placeholder="Descripción de la penalización"
                type="text"
                class="w-100"
                dusk="description"
            ></el-input>
        </div>
        <div class="col-md-12">
            <label for="type">Tipo</label>
            <el-select
                v-model="form.type"
                placeholder="Seleccione un tipo"
                class="w-100"
                dusk="type"
            >
                <el-option
                    label="Porcentaje"
                    value="percent"
                ></el-option>
                <el-option
                    label="Fijo"
                    value="fixed"
                ></el-option>
            </el-select>
        </div>
        <div class="col-md-12">
            <label for="amount">Valor</label>
            <el-input
                v-model="form.amount"
                placeholder="Valor de la penalización"
                type="number"
                class="w-100"
                dusk="amount"
            ></el-input>
        </div>
        <div class="col-md-12 mt-2">
            <el-button
            type="primary"
            @click="create"
            >
                Crear
            </el-button>
        </div>
    </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data(){
        return {
            resource: '/consignment/penalty',
            loading:false,
            form:{
                id: null,
                description: null,
                type:'percent',
                amount: 0.0,
            }
        }
    },
    methods:{
        open(){
            this.form = {
                id: null,
                description: null,
                type:'percent',
                amount: 0.0,
            }
        },
        close(){
            this.$emit('update:showDialog', false)
        },
        async create(){
            try{
                this.loading = true
               const response = await this.$http.post(this.resource, this.form)
               if(response.data.success){
                 this.$message({
                    type:'success',
                    message:'Penalización creada correctamente'
                })
               }
               
            }catch(e){
                this.$message({
                    type:'error',
                    message:'Ocurrió un error al crear la penalización'
                })
            }finally{
                this.loading = false
            }
        },  
    }
}
</script>