<template>
<el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.number}">
                            <label class="control-label">DNI</label>
                            <el-input v-model="form.number" :maxlength="11"></el-input>
                            <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.name}">
                            <label class="control-label">Nombres/Apellidos</label>
                            <el-input v-model="form.name"></el-input>
                            <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.business_id}">
                            <label class="control-label">Tipo De Negocio</label>
                            <el-input v-model="business_id" ></el-input>
                            <small class="form-control-feedback d-block" v-if="errors.business_id" v-text="errors.business_id[0]"></small> 
                        </div>
                    </div> -->
                    <!-- <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.telephone}">
                            <label class="control-label">Telefono</label>
                            <el-input v-model="telephone"></el-input>
                            <small class="form-control-feedback d-block" v-if="errors.telephone" v-text="errors.telephone[0]"></small>
            
                        </div>
                    </div> -->

                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.direccion}">
                            <label class="control-label">Direccion Cliente</label>
                                <el-input v-model="form.direccion"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.direccion" v-text="errors.direccion[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.direccion_secondary}">
                            <label class="control-label">Direccion Establecimiento</label>
                                <el-input v-model="form.direccion_secondary"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.direccion_secondary" v-text="errors.direccion_secondary[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.email}">
                            <label class="control-label">Email</label>
                                <el-input v-model="form.email"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.email" v-text="errors.email[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.ruc}">
                            <label class="control-label">RUC</label>
                                <el-input v-model="form.ruc"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.ruc" v-text="errors.ruc[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.user}">
                            <label class="control-label">Usuario</label>
                                <el-input v-model="form.user"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.user" v-text="errors.user[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.password}">
                            <label class="control-label">Contraseña </label>
                                <el-input v-model="form.password"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.password" v-text="errors.password[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.user_secondary}">
                            <label class="control-label">Usuario Secundario</label>
                                <el-input v-model="form.user_secondary"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.user_secondary" v-text="errors.user_secondary[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.password_secondary}">
                            <label class="control-label">Contraseña Del Usuario Secundario</label>
                                <el-input v-model="form.password_secondary"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.password_secondary" v-text="errors.password_secondary[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.password_certificate}">
                            <label class="control-label">Clave del Certificado Digital</label>
                                <el-input v-model="form.password_certificate"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.password_certificate" v-text="errors.password_certificate[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.date_certificate}">
                            <label class="control-label">Fecha </label>
                                <el-input v-model="form.date_certificate"></el-input>

                            <small class="form-control-feedback d-block" v-if="errors.date_certificate" v-text="errors.date_certificate[0]"></small>
                        </div>
                    </div>

                </div>
                
            </div>
            <div class="form-actions text-right pt-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit">Guardar</el-button>
            </div>
        </form>
    </el-dialog>
</template>
<script>

    export default {
        props: ['showDialog', 'recordId','records'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'history',
                errors: {},
                form: {}, 
            }
        },
        created() 
        {
            this.initForm() 
        },
        methods: {

            initForm() {
                
                this.errors = {}

                this.form = {
                    id: null,
                    name: null,
                    business_id: null,
                    number: null,
                    telephone: null,
                    direccion: null,
                    direccion_secondary: null,
                    email: null,
                    ruc: null,
                    user: null,
                    password: null,
                    user_secondary: null,
                    password_secondary: null,
                    password_certificate: null,
                    date_certificate: null,
                }

            },
            create() {

                this.titleDialog = (this.recordId)? 'Editar Historial':'Nuevo Historial'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`).then(response => {
                            this.setData(response.data.data)
                        })
                }
            },
            
            submit() {   
                
                this.transform()

                this.loading_submit = true  
                this.$http.post(`${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data 
                        } else {
                            console.log(error.response)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
                    
            },

            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            }
        }
    }
</script>
