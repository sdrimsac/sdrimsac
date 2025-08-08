<template>
    <el-dialog :title="titleDialog"  :visible="showDialog" @close="close" @open="create" class="certificate-form" width="600px">
        <br>
        <div class="form-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-danger': errors.password }">
                        <label class="control-label">Clave CDT</label>
                        <el-input v-model="form.password"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        <small class="form-control-feedback" v-if="errors.password" v-text="errors.password[0]"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-danger': errors.certificate }">
                        <label class="control-label">Certificado pfx</label>
                        <el-upload ref="upload" :headers="headers" :data="{ 'password': form.password }"
                            action="/certificates/uploads" :show-file-list="false" :auto-upload="false"
                            :multiple="false" :on-error="errorUpload" :on-success="successUpload">
                            <el-button class="btn_canjearsmall" slot="trigger" type="primary">Subir un Archivo
                                CDT</el-button>
                        </el-upload>
                        <small class="form-control-feedback" v-if="errors.certificate"
                            v-text="errors.certificate[0]"></small>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <template #footer>
            <div class="d-flex justify-content-end">
                <el-button class="btn_cancelarsmall" @click.prevent="close()">Cancelar</el-button>
                <el-button class="btn_guardarsmall" type="primary" @click.prevent="clickUpload" :loading="loading_submit">Aceptar</el-button>
            </div>
        </template>
       
    </el-dialog>
</template>

<script>

import { EventBus } from '../../helpers/bus'

export default {
    props: ['showDialog', 'recordId'],
    data() {
        return {
            loading_submit: false,
            headers: headers_token,
            titleDialog: null,
            resource: 'items',
            errors: {},
            form: {}
        }
    },
    created() {
        this.initForm()
    },
    methods: {
        initForm() {
            this.errors = {}
            this.form = {
                id: null,
                certificate: null,
                password: null,
            }
        },
        create() {
            this.titleDialog = 'Cargar Certificado Digital Tributario PEM'
        },
        //            submit() {
        //                this.loading_submit = true
        //                this.$http.post(`/${this.resource}`, this.form)
        //                    .then(response => {
        //                        if (response.data.success) {
        //                            this.$toast.success(response.data.message)
        //                            this.$eventHub.$emit('reloadData')
        //                            this.close()
        //                        } else {
        //                            this.$toast.error(response.data.message)
        //                        }
        //                    })
        //                    .catch(error => {
        //                        if (error.response.status === 422) {
        //                            this.errors = error.response.data.errors
        //                        } else {
        //                            console.log(error)
        //                        }
        //                    })
        //                    .then(() => {
        //                        this.loading_submit = false
        //                    })
        //            },
        clickUpload() {
            this.$refs.upload.submit();
        },
        close() {
            this.$emit('update:showDialog', false)
            this.initForm()
        },
        successUpload(response, file, fileList) {
            if (response.success) {
                this.$toast.success(response.message)
                this.$eventHub.$emit('reloadData')
                this.close()
            } else {
                this.$toast.error(response.message);
            }
        },
        errorUpload(response) {
            console.log(response)
        }
    }
}
</script>