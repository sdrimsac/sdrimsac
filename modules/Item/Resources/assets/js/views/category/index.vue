<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                <div class="col-sm-6">
                    <h6><span>{{ title }}</span></h6>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><span class="text-muted">{{ title }}</span></li>
                    </ol>
                </div>
                    <div class="col-sm-6">
                    <div class="bookmark">
                    <ul>
                        <li  v-if="typeUser != 'integrator'">
                            <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                                <a  href="javascript:void(0)"  @click.prevent="clickCreate()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                    <i data-feather="plus-circle"></i>
                                </a>
                            </el-tooltip>
                        </li>
              
                </ul>
                </div>
                </div>
                </div>
            </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0"> 
        <div class="card mb-0">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Listado de {{ title }}</h6>
            </div>
            <div class="card-body">
                <data-table :resource="resource"
                @clickReport="clickReport"
                >
                    <tr slot="heading">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Fecha creación</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.category }}</td>
                        <td>{{ row.created_at }}</td>
                        <td class="text-end">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info" @click.prevent="clickCreate(row.id)">Editar</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickDelete(row.id)">Eliminar</button>
                        </td>
                    </tr>
                </data-table>
            </div>

            <category-form 
                :showDialog.sync="showDialog"
                :recordId="recordId"
                    ></category-form> 
        </div>
    </div>
</template>

<script>

    import CategoryForm from './form.vue' 
    import DataTable from '../../../components/DataTable'
    import {deletable} from '../../../../js/mixins/deletable'

    export default {
        mixins: [deletable],
        components: {DataTable, CategoryForm},
        data() {
            return {
                title: null,
                showDialog: false, 
                resource: 'category',
                recordId: null,
            }
        },
        created() {
            this.title = 'Categorías'
        },
        methods: { 
              clickReport(query = null) {
            let { column, value } = query;
            window.open(`/category/export?column=${column||''}&value=${value||''}`, '_blank');
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
