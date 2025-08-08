<template>
<div>

            <div class="table-responsive" v-if="record">
                <table class="table table-hover table-bordered align-middle shadow-sm rounded">
                    <thead style="background: linear-gradient(90deg, #1e5a85 60%, #2980b9 100%); color: #fff;">
                        <tr>
                            <th style="color: #fff; font-weight: 600; letter-spacing: 1px;">Archivo</th>
                            <th class="text-center" style="color: #fff; font-weight: 600; letter-spacing: 1px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <i class="el-icon-document" style="color: #2980b9; margin-right: 8px;"></i>
                                <span style="font-size: 1.05em;">{{ record.filename || 'Certificado Digital' }}</span>
                            </td>
                            <td class="text-center">
                                <el-tooltip content="Eliminar Certificado Digital Tributario" placement="top">
                                    <button type="button" class="btn_cancelarsmall"
                                            style="background: #e74c3c; color: #fff; border: none; border-radius: 4px; padding: 6px 12px; transition: background 0.2s;"
                                            @click.prevent="clickDelete"
                                            @mouseover="event.target.style.background='#c0392b'"
                                            @mouseleave="event.target.style.background='#e74c3c'">
                                        <i class="el-icon-delete"></i>
                                    </button>
                                </el-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" v-else>
            <div class="col-md-12 text-left">
                <el-button  class="btn_guardarsmall" type="primary" icon="el-icon-plus" @click="clickCreate">Subir</el-button>
            </div>

        <certificates-form :showDialog.sync="showDialog"
                           :recordId="recordId"></certificates-form>
    </div>
</div>
</template>

<script>

    import CertificatesForm from './form.vue'
    import {deletable} from '../../mixins/deletable'

    export default {
        mixins: [deletable],
        components: {CertificatesForm},
        data() {
            return {
                showDialog: false,
                resource: 'certificates',
                recordId: null,
                record: {},
                config_system_env: false
            }
        },
        created() {
            this.$eventHub.$on('reloadData', () => {
                this.getData()
            })
            this.getData()
        },
        methods: {
            getData() {
                this.$http.get(`/${this.resource}/record`)
                    .then(response => {
                        this.record = response.data.certificate
                        this.config_system_env = response.data.config_system_env
                    })
            },
            clickCreate() {
                this.showDialog = true
            },
            clickDelete() {
                this.destroy(`/${this.resource}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            }
        }
    }
</script>
