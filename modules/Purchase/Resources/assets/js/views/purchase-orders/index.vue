<template>
  <div>
      <div class="container-fluid p-l-0 p-r-0">
        <div class="page-header">
          <div class="row">
            <div class="col-sm-6">
              <h6><span>Ordenes de compra</span></h6>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active"><span class="text-muted">Ordenes de compra</span></li>
              </ol>
            </div>
            <div class="col-sm-6">
              <div class="bookmark">
              <ul>
                  <li>
                      <el-tooltip class="item" effect="dark" content="Nuevo" placement="bottom-end">
                        <a :href="`/${resource}/create`" data-container="body" data-bs-toggle="popover" data-placement="top" data-original-title="Tables">
                            <i data-feather="plus-circle"></i>
                        </a>
                      </el-tooltip>
                </li>
                  
                </ul>
              </div>
              <!-- Bookmark Ends-->
            </div>
          </div>
        </div>
      </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid p-l-0 p-r-0">
          <div class="card mb-0">
            <div class="card-body">
              <data-table :resource="resource">
                <tr slot="heading">
                  <th>#</th>
                  <th class="text-center">F. Emisión</th>
                  <th class="text-center">F. Vencimiento</th>
                  <th>Proveedor</th>
                  <!-- <th>Estado</th> -->
                  <th>O. Compra</th>
                  <th>O. Venta</th>
                  <!-- <th>F. Pago</th> -->
                  <th class="text-center">Moneda</th>
                  <!-- <th class="text-end">T.Gratuita</th>
                  <th class="text-end">T.Inafecta</th>
                  <th class="text-end">T.Exonerado</th> -->
                  <th class="text-end">T.Gravado</th>
                  <th class="text-end">T.Igv</th>
                  <!-- <th>Percepcion</th> -->
                  <th class="text-end">Total</th>
                  <th class="text-center">Descarga</th>
                  <th class="text-end">Acciones</th>
                </tr>
                <tr></tr>
                <tr slot-scope="{ index, row }">
                  <td>{{ index }}</td>
                  <td class="text-center">{{ row.date_of_issue }}</td>
                  <td class="text-center">{{ row.date_of_due }}</td>
                  <td>
                    {{ row.supplier_name }}
                    <br />
                    <small v-text="row.supplier_number"></small>
                  </td>
                  <!-- <td>{{row.state_type_description}}</td> -->
                  <td>
                    {{ row.number }}
                    <br />
                    <small v-text="row.document_type_description"></small>
                    <br />
                  </td>
                  <td>{{row.sale_opportunity_number_full}}</td>

                  <!-- <td>{{ row.payment_method_type_description }}</td> -->
                  <!-- <td>{{ row.state_type_description }}</td> -->
                  <td class="text-center">{{ row.currency_type_id }}</td>
                  <!-- <td class="text-end">{{ row.total_exportation }}</td> -->
                  <!-- <td class="text-end">{{ row.total_free }}</td>
                  <td class="text-end">{{ row.total_unaffected }}</td>
                  <td class="text-end">{{ row.total_exonerated }}</td> -->
                  <td class="text-end">{{ row.total_taxed }}</td>
                  <td class="text-end">{{ row.total_igv }}</td>
                  <!-- <td class="text-end">{{ row.total_perception ? row.total_perception : 0 }}</td> -->
                  <td class="text-end">{{ row.total }}</td>
                  
                              <td class="text-center"> 

                                  <button type="button" class="btn waves-effect waves-light btn-sm btn-info"
                                          @click.prevent="clickDownload(row.external_id)">PDF</button>
                              </td>
                              
                  <td class="text-end">
                    <!-- <el-button
                      @click.prevent="clickOptions(row.id)"
                      size="mini"
                      type="primary"
                      :disabled="row.state_type_id == '03' || row.state_type_id == '11'"
                    >Generar comprobante</el-button>
                    <el-button
                      :disabled="row.state_type_id == '11'  || row.state_type_id == '03' "
                      type="danger"
                        size="mini"
                      @click.prevent="clickAnulate(row.id)"
                    >Anular</el-button> -->


                    <button type="button" v-if="!row.has_purchases && row.state_type_id!='11'" class="btn waves-effect waves-light btn-sm btn-custom m-1__2"
                            @click.prevent="clickCreate(row.id)">Editar</button>

                    <!-- <button type="button" v-if="!row.has_purchases && row.state_type_id!='11'" class="btn waves-effect waves-light btn-sm btn-success m-1__2"
                            @click.prevent="clickGenerateDocument(row.id)">Generar compra</button> -->

                            
                    <a :href="`/purchases/create/${row.id}`" class="btn waves-effect waves-light btn-sm btn-success m-1__2"  
                            v-if="!row.has_purchases && row.state_type_id!='11'">Generar compra</a>

                    <button type="button" v-if="!row.has_purchases && row.state_type_id!='11'" class="btn waves-effect waves-light btn-sm btn-danger m-1__2"
                            @click.prevent="clickAnulate(row.id)">Anular</button>

                    <button type="button" class="btn waves-effect waves-light btn-sm btn-info m-1__2"
                            @click.prevent="clickOptions(row.id)">Opciones</button>  
                  </td>
                </tr>
              </data-table>
            </div>

            <!-- <documents-voided :showDialog.sync="showDialogVoided"
            :recordId="recordId"></documents-voided>-->

            <!-- <document-generate
              :showDialog.sync="showDialogGenerateDocument"
              :recordId="recordId"
              :showClose="true"
            ></document-generate> -->

            
              <purchase-options :showDialog.sync="showDialogOptions"
                                :recordId="recordId"
                                :showClose="true"></purchase-options>
          </div>
          </div>
  </div>
</template>

<script>
    // import DocumentGenerate from "./partials/document_generate.vue";
    // import DocumentOptions from './partials/document_options.vue'
    import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
    import PurchaseOptions from './partials/options.vue'

    import {deletable} from '@mixins/deletable'


export default {
      mixins: [deletable],
      // components: {DocumentsVoided, DocumentOptions, DataTable},
      components: { DataTable , PurchaseOptions}, //DocumentOptions
      data() {
        return {
          showDialogVoided: false,
          resource: "purchase-orders",
          recordId: null,
          showDialogOptions: false,
          showDialogGenerateDocument: false,
        };
      },
      created() {},
      methods: {
          clickCreate(id = '') {
              location.href = `/${this.resource}/create/${id}`
          },
          clickVoided(recordId = null) {
            this.recordId = recordId;
            this.showDialogVoided = true;
          },
                  clickDownload(external_id) {
                      window.open(`/${this.resource}/download/${external_id}`, '_blank');                
                  },
          clickGenerateDocument(recordId) {
            this.recordId = recordId;
            this.showDialogGenerateDocument = true;
          },
          clickAnulate(id) {
            this.anular(`/${this.resource}/anular/${id}`).then(() =>
              this.$eventHub.$emit("reloadData")
            );
          },
          clickOptions(recordId = null) {
              this.recordId = recordId
              this.showDialogOptions = true
          },  
    }
};
</script>
