<!--Modal Facturar Compra -->
<template>
    <el-dialog :title="titleDialog" :visible="showFacturarDialog" @open="create" width="30%"
        :close-on-click-modal="false" :close-on-press-escape="false" :show-close="false" class="rounded-dialog">

        <form autocomplete="off" @submit.prevent="submit">

            <div class="form-body">
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" :class="{ 'has-danger': errors.document_type_id }">
                            <label class="control-label"><i class="fas fa-file-invoice"></i> Comprobante</label>
                            <el-select v-model="form.document_type_id">
                                <el-option v-for="option in document_types" :key="option.id" :value="option.id"
                                    :label="option.description"></el-option>
                            </el-select>

                            <small class="form-control-feedback" v-if="errors.series" v-text="errors.series[0]"></small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" :class="{ 'has-danger': errors.series }">
                            <label class="control-label"><i class="fas fa-hashtag"></i> Serie</label>
                            <el-input
                                v-model="form.series"
                                :maxlength="4"
                                @input="onSeriesInput"
                                style="text-transform:uppercase;"
                            >
                                <i slot="prefix" class="el-icon-edit-outline"></i>
                            </el-input>

                            <small class="form-control-feedback" v-if="errors.series" v-text="errors.series[0]"></small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" :class="{ 'has-danger': errors.number }">
                            <label class="control-label"><i class="fas fa-sort-numeric-up"></i> Número</label>
                            <el-input
                                v-model="form.number"
                                :maxlength="5"
                                @input="onNumberInput"
                                type="text"
                            >
                                <i slot="prefix" class="el-icon-edit-outline"></i>
                            </el-input>

                            <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]"></small>
                        </div>
                    </div>
                </div>
            </div>


        </form>

        <div class="d-flex justify-content-end" style="gap: 8px; margin-top: 10px;">
            <el-button class="btn_cancelarsmall" type="primary" icon="fas fa-times fa-lg"
                @click="clickClose">Cerrar</el-button>

            <el-tooltip content="Convierte  un factura a partir de una GR o NE" placement="top">
                <el-button class="btn_guardarsmall" icon="fas fa-save fa-lg" type="primary"
                    @click="submit()">Convertir</el-button>
            </el-tooltip>

        </div>




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
    props: ['showFacturarDialog', 'recordId', 'showClose', 'type', 'data'],
    data() {
        return {
            titleDialog: null,
            loading: false,
            resource: 'purchases',
            errors: {},
            document_types: [],
            form: {}
        }
    },
    created() {
        this.initForm()
    },
    methods: {
        onNumberInput(value) {
            // Solo números y máximo 5 dígitos
            this.form.number = value.replace(/\D/g, '').slice(0, 5);
        },
        onSeriesInput(value) {
            this.form.series = value.toUpperCase();
        },
        initForm() {
            this.errors = {}
            this.form = {
                id: null,
                document_type_id: null,
                series: null,
                number: null
            }
        },
        async create() {
            let document = []

            //_.filter(document,{}) 
            let document_type = this.data.document_type_description
            let documents = []
            this.form.id = this.data.id
            this.document_type_id = "01"
            let typei = 'registrada'
            this.titleDialog = `Facturar ${document_type}  ${typei}: ` + this.data.number_full
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    documents = response.data.document_types_invoice
                })
            if (this.data.document_type_id == "GU75") {
                this.document_types = _.filter(documents, (c) => {
                    return c.id != "GU75"
                })
            } else {
                this.document_types = _.filter(documents, (c) => {
                    return c.id != "NE76"
                })

            }

        },

        clickFinalize() {
            location.href = `/${this.resource}`
        },
        async submit() {
            await this.$http.post(`/${this.resource}/facturar`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message)
                        this.$eventHub.$emit('reloadData')
                        this.clickClose()
                    } else {
                        this.$toast.error(response.data.message)
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data
                    } else {
                        this.$toast.error(error.response.data.message)
                    }
                })
                .then(() => {
                    this.loading_submit = false
                })
        },
        clickNewDocument() {
            this.clickClose()
        },
        clickClose() {
            this.$emit('update:showFacturarDialog', false)
            this.initForm()
        },
    }
}
</script>