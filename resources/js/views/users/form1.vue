<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group" :class="{'has-danger': errors.name}">
                            <label class="control-label">Nombre</label>
                            <el-input v-model="form.name" :readonly="form.id!=null"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.email}">
                            <label class="control-label">Correo Electrónico</label>
                            <el-input v-model="form.email" :disabled="form.id!=null"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.email" v-text="errors.email[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.establishment_id}">
                            <label class="control-label">Establecimiento</label>
                            <el-select v-model="form.establishment_id" filterable>
                                <el-option v-for="option in establishments" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.establishment_id" v-text="errors.establishment_id[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4" v-show="form.id">
                        <div class="form-group" :class="{'has-danger': errors.api_token}">
                            <label class="control-label">Api Token</label>
                            <el-input v-model="form.api_token" :readonly="form.id!=null"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.api_token" v-text="errors.api_token[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.password}">
                            <label class="control-label">Contraseña</label>
                            <el-input v-model="form.password"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.password" v-text="errors.password[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.password_confirmation}">
                            <label class="control-label">Confirmar Contraseña</label>
                            <el-input v-model="form.password_confirmation"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.password_confirmation" v-text="errors.password_confirmation[0]"></small>
                        </div>
                    </div>

                    <div class="col-md-4" v-if="typeUser != 'integrator'">
                        <div class="form-group" :class="{'has-danger': errors.type}">
                            <label class="control-label">Perfil</label>
                            <el-select v-model="form.type" :disabled="form.id===1">
                                <el-option v-for="option in types" :key="option.type" :value="option.type" :label="option.description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.type" v-text="errors.type[0]"></small>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.telephone}">
                            <label class="control-label">N° Celular</label>
                            <el-input v-model="form.telephone"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.telephone" v-text="errors.telephone[0]"></small>
                        </div>
                    </div>
                   <!--  <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.license}">
                            <label class="control-label">N° Licencia de Conducir</label>
                            <el-input v-model="form.license"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.license" v-text="errors.license[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.category}">
                            <label class="control-label">Categoria Licencia de Conducir</label>
                            <el-input v-model="form.category"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.category" v-text="errors.category[0]"></small>
                        </div>
                    </div> -->
                    <div class="col-md-12" v-if="typeUser != 'integrator'">
                        <div class="form-group">
                            <label class="control-label">Módulos</label>
                            <div class="row">
                                <div class="col-4" v-for="module in form.modules">
                                    <el-checkbox v-model="module.checked" :disabled="form.locked" @change="changeModule(module.id, module.checked)">{{ module.description }}</el-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3" v-if="typeUser != 'integrator' && show_levels" >
                        <div class="form-group">
                            <label class="control-label">Nivel de acceso del módulo ventas</label>
                            <div class="row">
                                <div class="col-4" v-for="level in form.levels">
                                    <el-checkbox v-model="level.checked" :disabled="form.locked" >{{ level.description }}</el-checkbox>
                                </div>
                            </div>
                        </div>
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

    //import {EventBus} from '../../helpers/bus'
     import {serviceNumber} from '../../mixins/functions'
    export default {
        mixins: [serviceNumber],
        props: ['showDialog', 'recordId','typeUser','type'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: this.type,
                errors: {},
                form: {},
                modules: [],
                establishments: [],
                types: [],
                show_levels:false,
                 api_service_token:false,
            }
        },
        async created() {
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                     this.api_service_token = response.data.api_service_token
                    this.modules = response.data.modules
                    this.establishments = response.data.establishments
                    this.types = response.data.types
                })
            await this.initForm()
        },
        computed: {
            maxLength: function () {
                if (this.form.identity_document_type_id === '6') {
                    return 11
                }
                if (this.form.identity_document_type_id === '1') {
                    return 8
                }
            }
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    id: null,
                    name: null,
                    number:"",
                    email: null,
                    api_token: null,
                    establishment_id: null,
                    password: null,
                    password_confirmation: null,
                    locked:false,
                    type:this.type,
                    modules: [],
                    levels: [],
                    identity_document_type_id:"1",
                    telephone:null
                }

                this.modules.forEach(module => {
                    this.form.modules.push({
                        id: module.id,
                        description: module.description,
                        checked: false
                    })
                })

                this.show_levels = false

                // console.log(this.form.levels)
            },
              searchCustomer() {
                this.searchServiceNumberByType()
            },
            create() {
                if(this.type=='drivers'){
                    this.titleDialog = (this.recordId)? 'Editar Conductor de vehiculo':'Nuevo Conductor de vehiculo'
                }else{
                    this.titleDialog = (this.recordId)? 'Editar Usuario':'Nuevo Usuario'
                }
               
                
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                            this.show_levels = (this.form.levels.length > 0) ? true:false
                        })
                     //   this.form.identity_document_type_id="1"
                }
                if(this.input_person) {
                        this.form.identity_document_type_id = (this.input_person.identity_document_type_id) ? this.input_person.identity_document_type_id: this.form.identity_document_type_id
                        this.form.number = (this.input_person.number) ? this.input_person.number:''
                    }
            },
            async changeModule(module_id, checked){

                if(module_id == 1){

                    if(checked){
                        // console.log(mdl)
                        if(this.form.levels.length == 0 ){

                            let mdl = await _.find(this.modules, {'id':module_id})
                            mdl.levels.forEach(level => {
                                this.form.levels.push({
                                    id: level.id,
                                    level_id: level.id,
                                    module_id: level.module_id,
                                    description: level.description,
                                    checked: false
                                })
                            })
                            this.show_levels = true

                        }
                    }else{
                        this.form.levels = []
                        this.show_levels = false
                    }

                }
            },
              searchNumber(data) {
                this.form.name = data.nombre_completo;
                 
           },
            submit() {
                // console.log(this.form)
                this.loading_submit = true
                this.$http.post(`/${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.form.password = null
                            this.form.password_confirmation = null
                            this.$toast.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                            this.close()
                        } else {
                            this.$toast.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            this.$toast.error(error.response.data.message);
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            },
        }
    }
</script>
