<template>
<div class="card">
    <div class="card-header bg-primary">
        <h4 class="my-0 text-white">
            <i class="fa fa-list-ol text-white mr-2"></i>
            Numeración de Series de Facturación
            <el-tooltip class="item" effect="dark" content="La serie iniciará desde un número correlativo personalizado" placement="top-start">
                <i class="fa fa-info-circle"></i>
            </el-tooltip>
        </h4>
    </div>
    <div class="data-table-visible-columns">
         <el-button type="primary" 
                    class="" 
                    href="javascript:void(0)" 
                    @click.prevent="clickCreate()">
                    <i class="fa fa-list-ol text-white mr-2"></i>
                    <i class="fa fa-plus"></i>
                  Nueva Numeración
          </el-button>
    </div> 
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr slot="heading" class="bg-primary">
                        <th class="text-white">#</th>
                        <th class="text-white">Tipo comprobante</th>
                        <th class="text-white">Serie</th>
                        <th class="text-white text-center">Número a Iniciar</th>
                        <th class="text-white text-center">Emisión Inicializada</th>
                        <th class="text-white text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in records">
                        <td>{{ index + 1 }}</td>
                        <td>{{ row.document_type_description }}</td>
                        <td>{{ row.series }}</td>
                        <td class="text-center">{{ row.number }}</td>
                        <td class="text-center">{{ row.initialized_description }}</td>
                        <td class="text-end">
                            <!-- <button type="button" class="btn waves-effect waves-light btn-sm btn-info" @click.prevent="clickCreate(row.id)">Editar</button> -->
                            <template v-if="row.btn_delete">
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickDelete(row.id)">Eliminar</button>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <series-configurations-form :showDialog.sync="showDialog" :recordId="recordId"></series-configurations-form>
</div>
</template>

<script>
import SeriesConfigurationsForm from './form.vue'
import {
    deletable
} from '../../../../../../../resources/js/mixins/deletable'

export default {
    mixins: [deletable],
    components: {
        SeriesConfigurationsForm
    },
    data() {
        return {
            showDialog: false,
            resource: 'series-configurations',
            recordId: null,
            records: [],
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
            this.$http.get(`/${this.resource}/records`)
                .then(response => {
                    this.records = response.data
                })
        },
        clickCreate(recordId = null) {
            this.recordId = recordId
            this.showDialog = true
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit('reloadData')
            )
        }
    }
}
</script>
