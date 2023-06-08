<template>
    <div>

        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Ingresos diversos</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Ingresos diversos</span></li>
                  </ol>
                </div>
                 <div class="col-sm-6">
                  <div class="bookmark">
                  <ul>
                      <li>
                          <el-tooltip class="item" effect="dark" content="Nuevo Gasto" placement="bottom-end">
                            <a :href="`/${resource}/create`" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
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
            <div class="card-body">
                <data-table :resource="resource">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">Fecha Emisión</th>
                        <th>Cliente</th>
                        <th>Número</th>
                        <th>Motivo</th>
                        <!-- <th class="text-center">Pagos</th> -->
                        <th class="text-center">Moneda</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Dist. Ingreso</th>
                    <tr>
                    <tr slot-scope="{ index, row }" :class="{'text-danger': (row.state_type_id === '11'), 'text-warning': (row.state_type_id === '13'), 'border-light': (row.state_type_id === '01'), 'border-left border-info': (row.state_type_id === '03'), 'border-left border-success': (row.state_type_id === '05'), 'border-left border-secondary': (row.state_type_id === '07'), 'border-left border-dark': (row.state_type_id === '09'), 'border-left border-danger': (row.state_type_id === '11'), 'border-left border-warning': (row.state_type_id === '13')}">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td>{{ row.customer_name }}</td>
                        <td >{{ row.number }}<br/>
                            <small v-text="row.income_type_description"></small><br/>
                        </td>
                        <td class="">{{ row.income_reason_description }}</td>
                        <!-- <td class="text-center">
                            <button
                                type="button"
                                style="min-width: 41px"
                                class="btn waves-effect waves-light btn-sm btn-info m-1__2"
                                @click.prevent="clickExpensePayment(row.id)"
                            >Pagos</button>
                        </td> -->
                        <td class="text-center">{{ row.currency_type_id }}</td>
                        <td class="text-end">{{ row.total }}</td>

                        <td class="text-center">
                            <button type="button" style="min-width: 41px" class="btn waves-effect waves-light btn-sm btn-info m-1__2"
                                    @click.prevent="clickPayment(row.id)">
                                    <i class="fa fa-search"></i>
                            </button>
                            <button type="button" style="min-width: 41px" class="btn waves-effect waves-light btn-sm btn-danger m-1__2"
                                    @click.prevent="clickVoided(row.id)"
                                    v-if="row.state_type_id === '05'">
                                    <i class="fa fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                </data-table>
            </div>


            <income-payments :showDialog.sync="showDialogPayments"
                               :recordId="recordId"></income-payments>
  
 
        </div>
        </div>
    </div>

</template>

<script>

    import DataTable from '@components/DataTableResource.vue'
    import {deletable} from '@mixins/deletable'
    import IncomePayments from './partials/payments.vue'

    export default {
        mixins: [deletable],
        components: {DataTable, IncomePayments},
        data() {
            return {
                showDialogVoided: false,
                resource: 'finances/income',
                showDialogPayments: false,
                recordId: null,
                showDialogOptions: false
            }
        },
        created() {
        },
        methods: {
            clickExpensePayment(recordId) {
                this.recordId = recordId;
                this.showDialogExpensePayments = true
            },
            clickVoided(recordId) {
                this.voided(`/${this.resource}/voided/${recordId}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
            clickDownload(download) {
                window.open(download, '_blank');
            },
            clickOptions(recordId = null) {
                this.recordId = recordId
                this.showDialogOptions = true
            },
            clickPayment(recordId) {
                this.recordId = recordId;
                this.showDialogPayments = true;
            },
        }
    }
</script>
