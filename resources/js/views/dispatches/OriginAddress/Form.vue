<template>
    <el-dialog :close-on-click-modal="false" :title="titleDialog" :visible="showDialog" append-to-body @close="close"
        @open="create" width="40%">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div :class="{ 'has-danger': errors.address }" class="form-group">
                            <label class="control-label">Dirección</label>
                            <el-input v-model="form.address" @input="toUppercase"
                                style="text-transform: uppercase;"></el-input>
                            <small v-if="errors.address" class="form-control-feedback"
                                v-text="errors.address[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div :class="{ 'has-danger': errors.location_id }" class="form-group">
                            <label class="control-label">Ubigeo</label>
                            <el-cascader v-model="form.location_id" :options="locations" filterable
                                @change="updateUbigeoLabel"></el-cascader>
                            <label v-if="ubigeoLabel" class="mt-2" style="display:block;font-weight:normal;">
                                <span style="color:#888">Seleccionado:</span> {{ ubigeoLabel }}
                            </label>
                            <small v-if="errors.location_id" class="form-control-feedback"
                                v-text="errors.location_id[0]"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions d-flex justify-content-end text-right mt-4">
                <el-button class="btn_cancelarsmall" type="primary" @click.prevent="close()">
                    Cancelar
                </el-button>
                <el-button :loading="loading_submit" native-type="submit" class="btn_guardarsmall" type="primary">
                    Guardar
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>

export default {
    name: 'DispatchOriginAddressForm',
    props: ['showDialog', 'recordId', 'external'],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: 'origin_addresses',
            errors: {},
            form: {},
            locations: [],
            ubigeoLabel: ''
        }
    },
    async created() {
        await this.getTables();
        this.initForm()
    },
    methods: {
        updateUbigeoLabel(value) {
            // value es un array tipo [dep, prov, dist]
            if (!value || value.length === 0) {
                this.ubigeoLabel = '';
                return;
            }
            let dep, prov, dist;
            let depObj = this.locations.find(d => d.id === value[0]);
            dep = depObj ? depObj.name : '';
            if (depObj && depObj.children && value[1]) {
                let provObj = depObj.children.find(p => p.id === value[1]);
                prov = provObj ? provObj.name : '';
                if (provObj && provObj.children && value[2]) {
                    let distObj = provObj.children.find(dt => dt.id === value[2]);
                    dist = distObj ? distObj.name : '';
                }
            }
            this.ubigeoLabel = [dep, prov, dist].filter(Boolean).join(' / ');
        },
        async getTables() {
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.locations = response.data.locations
                })
        },
        initForm() {
            this.errors = {}
            this.form = {
                id: null,
                address: null,
                location_id: [],
                is_default: false,
                is_active: true,
            }
        },
        toUppercase(value) {
            this.form.address = value ? value.toUpperCase() : '';
        },
        async create() {
            this.initForm();
            this.titleDialog = (this.recordId) ? 'Editar dirección de partida' : 'Nueva dirección de partida'
            if (this.recordId) {
                await this.$http.get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data
                        // Actualiza el label si ya hay ubigeo seleccionado
                        this.updateUbigeoLabel(this.form.location_id)
                    })
            } else {
                this.updateUbigeoLabel([])
            }
        },
        async submit() {
            this.loading_submit = true
            // Asegura que se guarde en mayúsculas
            if (this.form.address) {
                this.form.address = this.form.address.toUpperCase();
            }
            await this.$http.post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$message.success(response.data.message)
                        this.$emit('success', response.data.id)
                        this.close()
                    } else {
                        this.$message.error(response.data.message)
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
        },
    }
}
</script>
