<!-- Nueva Categoría -->
<template>
<el-dialog  :title="titleDialog" 
            :visible="showDialog" 
            width="40%" 
            @close="close" 
            @open="create" 
            class="rounded-dialog" 
            :close-on-click-modal="false"
>
<br>
    <form autocomplete="off" @submit.prevent="submit">
        <div class="form-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" :class="{'has-danger': errors.name}">
                        <label class="control-label">
                            <i class="fas fa-tag"></i> Catergoría
                        </label>
                        <el-input v-model="form.name"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{'has-danger': errors.identifier}">
                        <label class="control-label">
                            <i class="fas fa-code"></i> Identificador (Clasificador)
                        </label>
                        <el-input v-model="form.identifier"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        <small class="form-control-feedback" v-if="errors.identifier" v-text="errors.identifier[0]"></small>
                    </div>
                </div>
                <!-- <div class="col-md-12">
                    <div class="form-group" :class="{'has-danger': errors.icono}">
                        <label class="control-label">Icono </label>
                        <el-upload class="avatar-uploader" :data="{'type': 'items'}" :headers="headers" action="/items/categories/uploads" :show-file-list="false" :on-success="onSuccess">
                            <img v-if="form.image_url" :src="form.image_url" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>

                    </div>
                </div> -->
            </div>
        </div>
        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <!-- Botón Cancelar -->
            <el-button class="btn-cancel btn-cancel:hover" icon="fas fa-times fa-lg" @click.prevent="close()">
                <span>Cancelar</span>
            </el-button>
            <!-- Botón Guardar -->
            <el-button class="btn-save btn-save:hover" icon="fas fa-save fa-lg" type="primary" native-type="submit" :loading="loading_submit">
                <span>Guardar</span>
            </el-button>
        </div>

    </form>
</el-dialog>
</template>

<script>
export default {
    props: ['showDialog', 'recordId'],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: 'items/categories',
            errors: {},
            form: {},
            headers: headers_token,
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
                name: null,
                icono: null,
                image_url: null,
                temp_path: null,
            }
        },
        create() {

            this.titleDialog = (this.recordId) ? 'Editar categoría' : 'Nueva categoría'
            if (this.recordId) {
                this.$http.get(`/${this.resource}/record/${this.recordId}`).then(response => {
                    this.form = response.data.data
                })
            }
        },
        submit() {

            this.loading_submit = true
            this.$http.post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
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
                        console.log(error.response)
                    }
                })
                .then(() => {
                    this.loading_submit = false
                })

        },
        onSuccess(response, file, fileList) {
            if (response.success) {
                this.form.icono = response.data.filename
                this.form.image_url = response.data.temp_image
                this.form.temp_path = response.data.temp_path
            } else {
                this.$toast.error(response.message)
            }
        },
        close() {
            this.$emit('update:showDialog', false)
            this.initForm()
        }
    }
}
</script>
