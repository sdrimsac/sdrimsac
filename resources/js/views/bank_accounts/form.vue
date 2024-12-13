<template>
<el-dialog  :title="titleDialog" 
            :visible="showDialog" 
            @close="close" 
            @open="create" 
            class="rounded-dialog" 
            :close-on-click-modal="false">

    <form autocomplete="off" @submit.prevent="submit">
        <div class="form-body">
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" :class="{'has-danger': errors.bank_id}">
                        <label class="control-label">
                            <i class="fas fa-university"></i> Banco
                        </label>
                        <el-select v-model="form.bank_id">
                            <el-option v-for="option in banks" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.bank_id" v-text="errors.bank_id[0]"></small>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group" :class="{'has-danger': errors.description}">
                        <label class="control-label">
                            <i class="fas fa-align-left"></i> Descripción
                        </label>
                        <el-input v-model="form.description" @input="convertToUppercase('description')"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        <small class="form-control-feedback" v-if="errors.description" v-text="errors.description[0]"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" :class="{'has-danger': errors.number}">
                        <label class="control-label">
                            <i class="fas fa-credit-card"></i> Número
                        </label>
                        <el-input v-model="form.number" @input="validateNumbers('number')"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]"></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" :class="{'has-danger': errors.currency_type_id}">
                        <label class="control-label">
                            <i class="fas fa-coins"></i> Moneda
                        </label>
                        <el-select v-model="form.currency_type_id">
                            <el-option v-for="option in currency_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.currency_type_id" v-text="errors.currency_type_id[0]"></small>
                    </div>
                </div>
                <!-- <div class="col-md-8">
                        <div class="form-group" :class="{'has-danger': errors.cci}">
                            <label class="control-label">CCI</label>
                            <el-input v-model="form.cci"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.cci" v-text="errors.cci[0]"></small>
                        </div>
                    </div> -->
                <div class="col-md-4">
                    <div class="form-group" :class="{'has-danger': errors.balance}">
                        <label class="control-label">
                            <i class="fas fa-balance-scale"></i> Balance
                        </label>
                        <el-input v-model="form.balance" type="number"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                        <small class="form-control-feedback" v-if="errors.balance" v-text="errors.balance[0]"></small>
                    </div>
                </div>
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
import Swal from 'sweetalert2'
import {
    EventBus
} from '../../helpers/bus'

export default {
    props: ['showDialog', 'recordId'],
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: 'bank_accounts',
            errors: {},
            form: {},
            banks: [],
            currency_types: [],
        }
    },
    created() {
        this.initForm()
        this.$http.get(`/${this.resource}/tables`)
            .then(response => {
                this.banks = response.data.banks
                this.currency_types = response.data.currency_types
            })
        //            await this.$http.get(`/${this.resource}/record`)
        //                .then(response => {
        //                    if (response.data !== '') {
        //                        this.form = response.data.data
        //                    }
        //                })
    },
    methods: {
        initForm() {
            this.errors = {}
            this.form = {
                id: null,
                bank_id: null,
                description: null,
                number: null,
                currency_type_id: null,
                cci: null,
            }
        },
        create() {
            this.titleDialog = (this.recordId) ? 'Editar Cuenta Bancaria' : 'Nueva Cuenta Bancaria'
            if (this.recordId) {
                this.$http.get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
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
                        console.log(error)
                    }
                })
                .then(() => {
                    this.loading_submit = false
                })
        },
        validateNumbers(field) {
            const value = this.form[field];
            if (/[^0-9]/.test(value)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Solo se permiten números.',
                    timer: 2000,
                    showConfirmButton: false
                });
                this.form[field] = value.replace(/[^0-9]/g, ""); // Reemplazar caracteres no válidos
            }
        },
        convertToUppercase(field) {
            this.form[field] = this.form[field].toUpperCase();
        },
        close() {
            this.$emit('update:showDialog', false)
            this.initForm()
        },
    }
}
</script>
