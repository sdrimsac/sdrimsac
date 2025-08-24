<template>
<el-dialog  :title="titleDialog" 
            :visible="showDialog" 
            @close="close" 
            @open="create" 
            :close-on-click-modal="false"
            width="25%"
            >
    <form autocomplete="off" @submit.prevent="submit">
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" :class="{'has-danger': errors.description}">
                        <label class="control-label">
                            <i class="fas fa-align-left"></i> Nombre del Banco
                        </label>
                        <el-input v-model="form.description" ref="descriptionInput"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        <small class="form-control-feedback" v-if="errors.description" v-text="errors.description[0]"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <!-- Botón Cancelar -->
            <el-button class="btn_cancelarsmall"  type="primary" icon="fas fa-times fa-lg" @click.prevent="close()">
                <span>Cancelar</span>
            </el-button>
            <!-- Botón Guardar -->
            <el-button class="btn_guardarsmall" icon="fas fa-save fa-lg" type="primary" native-type="submit" :loading="loading_submit">
                <span>Guardar</span>
            </el-button>
        </div>
        
    </form>
</el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

<script>
export default {
    props: ['showDialog', 'recordId'],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: 'banks',
            errors: {},
            form: {},
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
                description: null,
            }
        },
        create() {
            this.titleDialog = (this.recordId) ? 'Editar Banco' : 'Nuevo Banco'
            if (this.recordId) {
                this.$http.get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data
                    })
            }
            this.$nextTick(() => {
                this.$refs.descriptionInput.focus()
            })
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
