<template>
<div>
 <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Clientes</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Clientes</span></li>
                  </ol>
                </div>
                <div class="col-sm-6">
                  <div class="bookmark">
                  <ul>
                      <li>
                          <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                            <a href="javascript:void(0)" @click.prevent="clickCreate()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
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
          <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">                 
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de clientes</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Nombre</th>
                            <th class="text-end">Número</th>
                        
                            <th class="text-end">Acciones</th>
                        <tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.name }}</td>
                            <td class="text-end">{{ row.number }}</td>
                        
                            <td class="text-end">
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-info" @click.prevent="clickCreate(row.id)">Editar</button>
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickDelete(row.id)">Eliminar</button>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <customers-form :showDialog.sync="showDialog"
                                :recordId="recordId"></customers-form>
            </div>
        </div>
</div>
</template>

<script>

    import CustomersForm from './form.vue'
    import DataTable from '../../components/DataTable.vue'
    import {deletable} from '../../mixins/deletable'

    export default {
        mixins: [deletable],
        components: {CustomersForm, DataTable},
        data() {
            return {
                showDialog: false,
                resource: 'customers',
                recordId: null,
            }
        },
        created() {
          //  console.log("holaaaaaaaaaaaaaaaaaaaaa")
        },
        methods: {
            clickCreate(recordId = null) {
                this.recordId = recordId
                this.showDialog = true
            },
            getQueryParameters() {
                return queryString.stringify({
                    page: this.pagination.current_page,
                    limit: this.limit,
                    ...this.search
                })
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            }
        }
    }
</script>
