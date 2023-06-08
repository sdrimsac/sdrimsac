<template>
    <div>
    <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Comprobantes</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Compras</span></li>
                  </ol>
                </div>
              <div class="col-12 col-md-6 d-flex align-items-start justify-content-end">
                <!-- Contact Button Start -->
                <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" @click.prevent="clickNuevo()">
                <i class="icofont-plus-circle"></i>
                  <span>Nuevo</span>
                </button>
                <!-- Contact Button End -->
              </div>
              </div>
            </div>
          </div>
    <!-- <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                <div class="col-sm-6">
                    <h6><span>Compras</span></h6>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><span class="text-muted">Compras</span></li>
                    </ol>
                </div>
                    <div class="col-sm-6">
                    <div class="bookmark">
                    <ul>
                        <li  v-if="typeUser != 'integrator'">
                            <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                                <a  :href="`/${resource}/create`" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                    <i data-feather="plus-circle"></i>
                                </a>
                            </el-tooltip>
                        </li>
                         <li  v-if="typeUser != 'integrator'">
                            <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                                <a  href="javascript:void(0)" @click.prevent="clickImport()" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                                   <i data-feather="share"></i>
                                </a>
                            </el-tooltip>
                        </li>
                </ul>
                </div>
                </div>
                </div>
            </div>
    </div> -->
    <div class="container-fluid p-l-0 p-r-0">
        <div class="card mb-0">
            <div class="data-table-visible-columns">
                <el-dropdown :hide-on-click="false">
                    <el-button type="primary">
                        Mostrar/Ocultar columnas<i class="el-icon-arrow-down el-icon--right"></i>
                    </el-button>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item v-for="(column, index) in columns" :key="index">
                            <el-checkbox v-model="column.visible">{{ column.title }}</el-checkbox>
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </div>
            <div class="card-body">
                <data-table :resource="resource" @clickReport="clickReport">
                    <tr slot="heading">
                        <th>#</th>
                        <th class="text-center">F. Emisión</th>
                        <th class="text-center" v-if="columns.date_of_due.visible" >F. Vencimiento</th>
                        <th>Proveedor</th>
                        <th>Estado</th>
                        <th>Número</th>
                        <th>Productos</th>
                        <th>Pagos</th>
                        <!-- <th>F. Pago</th> -->
                        <!-- <th>Estado</th> -->
                        <th class="text-center">Moneda</th>
                        <!-- <th class="text-end">T.Exportación</th> -->
                        <th v-if="columns.total_free.visible"  class="text-end">T.Gratuita</th>
                        <th v-if="columns.total_unaffected.visible" class="text-end">T.Inafecta</th>
                        <th v-if="columns.total_exonerated.visible" class="text-end">T.Exonerado</th>
                        <th v-if="columns.total_taxed.visible" class="text-end">T.Gravado</th>
                        <th v-if="columns.total_igv.visible" class="text-end">T.Igv</th>
                        <th v-if="columns.total_perception.visible" >Percepcion</th>
                        <th class="text-end">Total</th>
                        <!-- <th class="text-center">Descargas</th> -->
                        <th class="text-end">Acciones</th>
                    <tr>
                    <tr slot-scope="{ index, row }">
                        <td>{{ index }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td v-if="columns.date_of_due.visible" class="text-center">{{ row.date_of_due }}</td>
                        <td>{{ row.supplier_name }}<br/><small v-text="row.supplier_number"></small></td>
                         <td>{{row.state_type_payment_description}}</td>
                        <template v-if="row.number!='-0'">
                        <td>{{ row.number }}<br/>
                            <small v-text="row.document_type_description"></small><br/>
                        </td>
                        </template>
                        <template v-else>
                            <td>{{ row.number_full}}<br/>
                                <small v-text="row.document_type_description"></small><br/>
                            </td>
                        </template>
                        <td>

                            <el-popover
                                placement="right"
                                width="400"
                                trigger="click">
                                <el-table :data="row.items">
                                    <el-table-column width="80" property="key" label="#"></el-table-column>
                                    <el-table-column width="220" property="description" label="Nombre"></el-table-column>
                                    <el-table-column width="90" property="quantity" label="Cantidad"></el-table-column>
                                </el-table>
                                <el-button slot="reference"> <i class="fa fa-eye"></i></el-button>
                            </el-popover>

                        </td>
                        <!-- <td>{{ row.payment_method_type_description }}</td> -->
                        <!-- <td>
                            <template v-for="(it,ind) in row.payments">
                                {{it.payment_method_type_description}} - {{it.payment}}
                            </template>
                        </td> -->
                        <!-- <td>{{ row.state_type_description }}</td> -->
                        <td class="text-end">
                            <button
                                v-if="row.state_type_id != '11'"
                                type="button"
                                style="min-width: 41px"
                                class="btn waves-effect waves-light btn-sm btn-info m-1__2"
                                @click.prevent="clickPurchasePayment(row.id)"
                            >Pagos</button>
                        </td>

                        <td class="text-center">{{ row.currency_type_id }}</td>
                        <!-- <td class="text-end">{{ row.total_exportation }}</td> -->
                        <td v-if="columns.total_free.visible" class="text-end">{{ row.total_free }}</td>
                        <td v-if="columns.total_unaffected.visible" class="text-end">{{ row.total_unaffected }}</td>
                        <td v-if="columns.total_exonerated.visible" class="text-end">{{ row.total_exonerated }}</td>
                        <td v-if="columns.total_taxed.visible" class="text-end">{{ row.total_taxed }}</td>
                        <td v-if="columns.total_igv.visible" class="text-end">{{ row.total_igv }}</td>
                        <td v-if="columns.total_perception.visible" class="text-end">{{ row.total_perception ? row.total_perception : 0 }}</td>
                        <td class="text-end">{{ row.total   }}</td>
                        <td>

                            <a v-if="row.state_type_id != '11'" :href="`/${resource}/edit/${row.id}`" type="button" class="btn waves-effect waves-light btn-sm btn-info">Editar</a>
                            <button v-if="row.state_type_id != '11'" type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickAnulate(row.id)">Anular</button>
                            <button v-if="row.state_type_id == '11'" type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickDelete(row.id)">Eliminar</button>
                            <button v-if="row.document_type_description!='FACTURA ELECTRÓNICA'" type="button" class="btn waves-effect waves-light btn-sm btn-success   " @click.prevent="clickFacturar(row)">Facturar</button>


                        </td>

                        <!-- <td class="text-end">
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                    @click.prevent="clickVoided(row.id)"
                                    v-if="row.btn_voided">Anular</button>
                            <a :href="`/${resource}/note/${row.id}`" class="btn waves-effect waves-light btn-sm btn-warning"
                               v-if="row.btn_note">Nota</a>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickResend(row.id)"
                                    v-if="row.btn_resend">Reenviar</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickConsultCdr(row.id)"
                                    v-if="row.btn_consult_cdr">Consultar CDR</button>
                            <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                    @click.prevent="clickOptions(row.id)">Opciones</button>
                        </td> -->
                    </tr>
                </data-table>
            </div>

            <!-- <documents-voided :showDialog.sync="showDialogVoided"
                            :recordId="recordId"></documents-voided>

            <document-options :showDialog.sync="showDialogOptions"
                              :recordId="recordId"
                              :showClose="true"></document-options> -->

            <purchase-import :showDialog.sync="showImportDialog"></purchase-import>
        </div>
    </div>
     <purchase-payments
            :showDialog.sync="showDialogPurchasePayments"
            :purchaseId="recordId"
            :external="true"
            ></purchase-payments>
        <FacturarModal :showFacturarDialog.sync="showFacturarDialog" :data.sync="data"></FacturarModal>
</div>


</template>

<script>

    // import DocumentsVoided from './partials/voided.vue'
    // import DocumentOptions from './partials/options.vue'

    import DataTable from '../../components/DataTable.vue'
    import {deletable} from '../../mixins/deletable'
    import PurchaseImport from './import.vue'
    import PurchasePayments from '@viewsModulePurchase/purchase_payments/payments.vue'
     import FacturarModal from './partials/facturar.vue'
import queryString from "query-string";

    export default {
        mixins: [deletable],
        // components: {DocumentsVoided, DocumentOptions, DataTable},
        components: {DataTable, PurchaseImport, PurchasePayments,FacturarModal},
        data() {
            return {
                showDialogVoided: false,
                resource: 'purchases',
                recordId: null,
                showDialogOptions: false,
                showDialogPurchasePayments: false,
                showImportDialog: false,
                data:{},
                showFacturarDialog:false,
                columns: {
                    date_of_due: {
                        title: 'F. Vencimiento',
                        visible: false
                    },
                    total_free: {
                        title: 'T.Gratuita',
                        visible: false
                    },
                    total_unaffected: {
                        title: 'T.Inafecta',
                        visible: false
                    },
                    total_exonerated: {
                        title: 'T.Exonerado',
                        visible: false
                    },
                    total_taxed: {
                        title: 'T.Gravado',
                        visible: false
                    },
                    total_igv: {
                        title: 'T.Igv',
                        visible: false
                    },
                    total_perception:{
                        title: 'Percepcion',
                        visible: false
                    }

                }
            }
        },
        created() {
        },
        methods: {
            clickReport(type) {
               let params =  queryString.stringify({
               ...type
            });
            console.log(params);
                window.open(`purchases/export/excel/?${params}`, '_blank');
            },
            clickPurchasePayment(recordId) {
                this.recordId = recordId;
                this.showDialogPurchasePayments = true
            },
            clickVoided(recordId = null) {
                this.recordId = recordId
                this.showDialogVoided = true
            },
            clickDownload(download) {
                window.open(download, '_blank');
            },
            clickOptions(recordId = null) {
                this.recordId = recordId
                this.showDialogOptions = true
            },
            clickAnulate(id)
            {
                this.anular(`/${this.resource}/anular/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
             clickNuevo(){
                 location.href=`/${this.resource}/create`;
            },
            clickDelete(id)
            {
                this.delete(`/${this.resource}/delete/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            },
            clickFacturar(row){
                this.showFacturarDialog=true
                this.data=row
            },
             clickImport() {
                this.showImportDialog = true
            },
        }
    }
</script>
