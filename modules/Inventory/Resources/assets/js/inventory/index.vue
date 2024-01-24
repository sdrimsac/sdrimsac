<template>
    <div>
    <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6>{{ title }}</h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">{{ title }}</span></li>
                  </ol>
                </div>
                 <div class="col-sm-6">
                  <div class="bookmark">
                  <ul>
                    <li  v-if="typeUser != 'admin'">
                          <el-tooltip class="item" effect="dark" content="Ingreso" placement="bottom-end">
                            <a  href="javascript:void(0)" @click.prevent="clickCreate('input')" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                <i data-feather="plus-circle"></i>
                            </a>
                          </el-tooltip>
                    </li>
                    <li  v-if="typeUser != 'integrator'">
                          <el-tooltip class="item" effect="dark" content="Salida" placement="bottom-end">
                            <a  href="javascript:void(0)" @click.prevent="clickOutput()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                               <i data-feather="log-out"></i>
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
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th>Producto</th>
                        <th>Almacén</th>
                        <th class="text-end">Stock</th>
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td>{{ row.item_fulldescription }}</td>
                        <td>{{ row.warehouse_description }}</td>
                        <td class="text-end">{{ row.stock }}</td>
                        <td class="text-end">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickMove(row.id)">Trasladar</button>
                            <button v-if="typeUser " type="button" class="btn waves-effect waves-light btn-sm btn-warning"
                                    @click.prevent="clickRemove(row.id)">Remover</button>
                        </td>
                    </tr>
                </data-table>
            </div>

            <inventories-form
                            :showDialog.sync="showDialog"
                            :type="typeTransaction"
                                ></inventories-form>

            <inventories-form-output
                            :showDialog.sync="showDialogOutput"
                            ></inventories-form-output>

            <inventories-move :showDialog.sync="showDialogMove"
                              :recordId="recordId"></inventories-move>
            <inventories-remove :showDialog.sync="showDialogRemove"
                                :recordId="recordId"></inventories-remove>
        </div>
    </div>
    </div>
</template>

<script>

    import InventoriesForm from './form.vue'
    import InventoriesFormOutput from './form_output.vue'

    import InventoriesMove from './move.vue'
    import InventoriesRemove from './remove.vue'
    import DataTable from '../../../../../../resources/js/components/DataTable.vue'
    export default {
        props: ['type', 'typeUser'],
        components: {DataTable, InventoriesForm, InventoriesMove, InventoriesRemove, InventoriesFormOutput},
        data() {
            return {
                title: null,
                showDialog: false,
                showDialogMove: false,
                showDialogRemove: false,
                showDialogOutput: false,
                resource: 'inventory',
                recordId: null,
                typeTransaction:null,
            }
        },
        created() {
            this.title = 'Inventario'
        },
        methods: {
            clickMove(recordId) {
                this.recordId = recordId
                this.showDialogMove = true
            },
            clickCreate(type) {
                this.recordId = null
                this.typeTransaction = type
                this.showDialog = true
            },
            clickRemove(recordId) {
                this.recordId = recordId
                this.showDialogRemove = true
            },
            clickOutput()
            {
                this.recordId = null
                this.showDialogOutput = true

            }

        }
    }
</script>
