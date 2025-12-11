<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h4 class="my-0 text-white">Listado de personal de la empresa</h4>
                    <div>
                        <el-button 
                            type="primary"
                            class="btn_guardarsmall"
                            @click.prevent="clickCreate()">
                            Nuevo personal
                        </el-button>
                    </div>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" style="background-color: #073f68;">
                            <th style="color: #fff;">#</th>
                            <th style="color: #fff;">Nombre</th>
                            <!-- <th style="color: #fff;">Puesto</th> -->
                            <th class="text-right" style="color: #fff;">Número</th>
                            <!-- <th class="text-right" style="color: #fff;">Salario Base</th> -->
                            <th class="text-right" style="color: #fff;">Acciones</th>
                        </tr>
                        <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }"
>
                            <td>{{ index }}</td>
                            <td>{{ row.name }}</td>
                            <!-- <td>{{ row.job_position ? row.job_position : 'Sin cargo' }}</td> -->
                            <td class="text-right">{{ row.number }}</td>
                            <!-- <td class="text-right">{{ row.base_salary !== null ? row.base_salary : '-' }}</td> -->
                            <td class="text-right">
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickCreate(row.id)">Editar</button>
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                    @click.prevent="clickDelete(row.id)">Eliminar</button>
                            </td>
                        </tr>
                    </data-table>
                </div>
                <suppliers-form :showDialog.sync="showDialog" :recordId="recordId"></suppliers-form>
            </div>
        </div>
    </div>
</template>


<script>
import SuppliersForm from './form.vue'
import DataTable from '../../components/DataTable.vue'
import {
    deletable
} from '../../mixins/deletable'

export default {
    mixins: [deletable],
    components: {
        SuppliersForm,
        DataTable
    },
    data() {
        return {
            showDialog: false,
            resource: 'person_staff',
            recordId: null,
        }
    },
    created() { 

    },
    mounted() {
        if (window.feather) {
            window.feather.replace();
        }
    },
    methods: {
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
