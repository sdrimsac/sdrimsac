<template>
<div>

            <div class="table-responsive" v-if="record">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Archivo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ record }}</td>
                        <td class="text-end">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                    @click.prevent="clickDelete">Eliminar</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" v-else>
            <div class="col-md-12 text-left">
                <el-button  type="primary" icon="el-icon-plus" @click="clickCreate">Subir</el-button>
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
