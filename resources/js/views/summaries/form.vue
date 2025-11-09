<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" :width="dialogWidth">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group" :class="{ 'has-danger': errors.date_of_reference }">
                            <div class="d-flex align-items-center">
                                <label class="control-label me-3 mb-0">Fecha de CPE</label>
                                <el-date-picker
                                    v-model="form.date_of_reference"
                                    type="date"
                                    :clearable="false"
                                    value-format="yyyy-MM-dd"
                                    @change="changeDateOfReference"
                                    style="max-width:220px; margin-right:12px;">
                                </el-date-picker>
                                <button type="button" class="btn_buscar" @click.prevent="clickSearchDocuments" dusk="search-documents" style="margin-right:10px;">
                                    <i :class="loading_search ? 'el-icon-loading' : 'el-icon-search'"></i>
                                    Buscar CPE
                                </button>
                            </div>
                            <small class="form-control-feedback" v-if="errors.date_of_reference" v-text="errors.date_of_reference[0]"></small>
                        </div>

                    </div>

                </div>
                <div class="row mt-2" v-if="form.documents.length > 0">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead style="background-color: #073f68; color: #ffffff;">
                                    <tr>
                                        <th class="text-white">#</th>
                                        <th class="text-white">Número</th>
                                        <th class="text-center text-white">Moneda</th>
                                        <th class="text-end text-white">T.Exportación</th>
                                        <th class="text-end text-white">T.Gratuita</th>
                                        <!-- <th class="text-end text-white">T.Inafecta</th> -->
                                        <!-- <th class="text-end text-white">T.Exonerado</th>
                                    <th class="text-end text-white">T.Gravado</th>
                                    <th class="text-end text-white">T.Igv</th> -->
                                        <th class="text-end text-white">Total</th>
                                        <th class="text-white"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in form.documents" :key="index"
                                        :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <small>{{ row.document_type_description &&
                                                row.document_type_description.includes('BOLETA DE VENTA ELECTRÓNICA') ?
                                                'BOLETA' : row.document_type_description }}</small><br />
                                            <small v-if="row.affected_document" v-text="row.affected_document"></small>

                                            {{ row.number }}
                                        </td>
                                        <td class="text-center">{{ row.currency_type_id }}</td>
                                        <td class="text-end">
                                            T.Exportación {{ row.total_exportation }} <br>
                                            T.Gratuita {{ row.total_free }}<br>
                                            T.Inafecta {{ row.total_unaffected }}<br>



                                        </td>
                                        <!-- <td class="text-end">{{ row.total_free }}</td>
                                    <td class="text-end">{{ row.total_unaffected }}</td>
                                    <td class="text-end">{{ row.total_exonerated }}</td>
                                    <td class="text-end">{{ row.total_taxed }}</td>
                                    <td class="text-end">{{ row.total_igv }}</td> -->
                                        <td class="text-end">
                                            T.Exonerado {{ row.total_exonerated }}<br>
                                            T.Gravado {{ row.total_taxed }}<br>
                                            T.Igv {{ row.total_igv }}<br>

                                        </td>
                                        <td class="text-end">{{ row.total_igv }}</td>
                                        <td class="d-flex align-items-center justify-content-center">
                                            <el-button type="danger" icon="el-icon-delete" size="mini"
                                                @click.prevent="clickRemoveDocument(index)"></el-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions pt-2 pb-2 d-flex justify-content-end">
                <el-button class="btn_cancelarsmall me-2" type="danger" @click.prevent="close()">Cancelar</el-button>
                <el-button class="btn_guardarsmall" type="primary" native-type="submit" :loading="loading_submit"
                    v-if="form.documents.length > 0" dusk="save-summary">Guardar</el-button>
            </div>
        </form>
    </el-dialog>
</template>
<script>

export default {
    props: ['showDialog'],
    data() {
        return {
            loading_submit: false,
            loading_search: false,
            titleDialog: null,
            resource: 'summaries',
            errors: {},
            form: {},
            // dialogWidth será '90%' cuando la pantalla sea >= 1200px, si no '60%'
            dialogWidth: '75%',
        }
    },
    created() {
        this.initForm()
    },
    mounted() {
        // calcular ancho inicial y suscribir al resize
        this.updateDialogWidth()
        window.addEventListener('resize', this.updateDialogWidth)
    },
    beforeDestroy() {
        // limpiar listener al destruir el componente
        window.removeEventListener('resize', this.updateDialogWidth)
    },
    methods: {
        updateDialogWidth() {
            // si el ancho de la ventana es mayor o igual a 1200px usar 90%, sino 60%
            try {
                const w = window.innerWidth || document.documentElement.clientWidth
                this.dialogWidth = w >= 1200 ? '60%' : '90%'
            } catch (e) {
                // fallback
                this.dialogWidth = '90%'
            }
        },
        initForm() {
            this.loading_submit = false,
                this.loading_search = false,
                this.errors = {}
            this.form = {
                id: null,
                summary_status_type_id: '1',
                date_of_issue: null,
                date_of_reference: moment().format('YYYY-MM-DD'),
                documents: [],
            }
        },
        create() {
            this.titleDialog = 'Registrar Resumen de Boletas de Venta Electrónicas'
            this.changeDateOfReference()
        },
        clickSearchDocuments() {
            this.loading_search = true
            this.$http.post(`/${this.resource}/documents`, {
                'date_of_reference': this.form.date_of_reference
            })
                .then(response => {
                    this.form.documents = response.data.data
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message)
                })
                .then(() => {
                    this.loading_search = false
                })
        },
        changeDateOfReference() {
            this.form.documents = []
        },
        clickRemoveDocument(index) {
            this.form.documents.splice(index, 1)
        },
        submit() {
            this.loading_submit = true
            this.$http.post(`${this.resource}`, this.form)
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
                        this.errors = error.response.data.errors
                    } else {
                        this.$toast.error(error.response.data.message)
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
