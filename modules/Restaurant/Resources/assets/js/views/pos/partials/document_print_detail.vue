<template>
  <div v-loading="loading" class="card-body">
    <el-pagination
      @current-change="getRecords"
      layout="total, prev, pager, next"
      :total="pagination.total"
      :current-page.sync="pagination.current_page"
      :page-size="pagination.per_page"
    ></el-pagination>
    <div class="container table-responsive col-md-12">
      <table
        class="table table-hover table-striped table-condensed table-responsive"
        style="width:100%;     white-space: nowrap;"
      >
        <thead>
          <tr class="bg-primary">
            <th v-if="type == 'documents'" class="text-white">SUNAT</th>
            <th v-if="type == 'saleNotes'" class="text-white">Acciones</th>
            <th class="text-white">Acciones</th>
            <th
              v-if="
                                configuration.restaurant &&
                                    (type == 'documents' || type == 'saleNotes')
                            "
              class="text-white"
            >N° Mesa</th>
            <th class="text-white">Número</th>
            <th class="text-white">Fecha</th>
            <th class="text-white">Cliente</th>
            <th v-if="type == 'quotations'" class="text-white">Vendedor</th>
            <th v-if="type == 'quotations'" class="text-white">Dctos</th>
            <th v-if="type == 'documents'" class="text-white">N/V</th>
            <th class="text-white">Estado</th>
            <th v-if="type == 'documents' || type == 'saleNotes'" class="text-white">Saldo</th>
            <th class="text-white">Monto</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(data, idx) in records"
            :key="idx"
            :class="
                            `${
                                data.state_type_id == '11' ||
                                data.state_type_id == '13'
                                    ? 'bg-danger text-white'
                                    : ''
                            }`
                        "
          >
            <td
              :class="
                                `${data.state_type_id != '11' &&
                                    data.state_type_id != '13' &&
                                    'text-white'}`
                            "
              v-if="type == 'documents'"
            >
              <div class="dropdown-as-select d-inline-block" data-childselector="span">
                <button
                  v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                  class="btn p-0"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span
                    class="btn btn-primary dropdown-toggle"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-delay="0"
                    title
                    data-bs-original-title="Item Count"
                    aria-label="Item Count"
                  >
                    <i class="fas fa-list"></i>
                  </span>
                </button>

                <div class="dropdown-menu dropdown-menu-end col-md-2 col-1">
                  <template>
                    <template
                      v-if="
                                                configuration.caja_actions &&
                                                    configuration.internal_voided
                                            "
                    >
                      <el-button
                        class="col-md-12 col-12"
                        v-if="
                                                    data.state_type_id == '01'
                                                "
                        @click="
                                                    clickDeleteDocument(data.id)
                                                "
                      >Anular internamente</el-button>
                      <br
                        v-if="
                                                    data.state_type_id == '01'
                                                "
                      />
                      <el-button
                        v-if="
                                                    data.document_type_id ==
                                                        '01' &&
                                                        data.state_type_id ==
                                                            '05'
                                                "
                        class="col-md-12 col-12"
                        @click="clickVoided(data.id)"
                      >Anular sunat</el-button>
                      <br
                        v-if="
                                                    data.document_type_id ==
                                                        '01'
                                                "
                      />
                      <el-button
                        v-if="
                                                    data.state_type_id == '05'
                                                "
                        class="col-md-12 col-12"
                        @click="clickNote(data.id)"
                      >Nota de crédito</el-button>
                      <br
                        v-if="
                                                    data.state_type_id == '05'
                                                "
                      />
                      <el-button
                        v-if="data.is_credit"
                        class="col-md-12 col-12"
                        @click="clickPayment(data.id)"
                      >Pagos</el-button>
                      <br v-if="data.is_credit" />
                    </template>
                  </template>
                  <el-button
                    class="col-md-12 col-12"
                    v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                data.document_type_id == '01'
                                        "
                    @click="clickReStore(data.id)"
                  >Recrear</el-button>
                  <br
                    v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                data.document_type_id == '01'
                                        "
                  />
                  <el-button
                    class="col-md-12 col-12"
                    v-if="
                                            type == 'documents' &&
                                                data.document_type_id == '01' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                    plain
                    @click="clickSendOnline(data.id)"
                  >Reenviar</el-button>
                  <br
                    v-if="
                                            type == 'documents' &&
                                                data.document_type_id == '01'
                                        "
                  />

                  <el-button
                    class="col-md-12 col-12"
                    v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                    @click="clickValidarCpe(data.id)"
                  >Validar cpe</el-button>
                  <br
                    v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                  />

                  <el-button
                    class="col-md-12 col-12"
                    v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                    @click="clickGenerateGuie(data.id)"
                  >Guia</el-button>
                </div>
              </div>
            </td>
            <td
              :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
              v-if="type == 'saleNotes'"
            >
              <div class="dropdown-as-select d-inline-block" data-childselector="span">
                <button
                  v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                  class="btn p-0"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span
                    class="btn btn-primary dropdown-toggle"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-delay="0"
                    title
                    data-bs-original-title="Item Count"
                    aria-label="Item Count"
                  >
                    <i class="fas fa-list"></i>
                  </span>
                </button>

                <div class="dropdown-menu dropdown-menu-end col-md-2 col-1">
                  <el-button
                    class="col-md-12 col-12"
                    v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                !data.changed
                                        "
                    @click="clickGenerate(data.id)"
                  >Generar comprobantes</el-button>
                  <br
                    v-if="
                                            (data.state_type_id != '11' ||
                                                data.state_type_id != '13') &&
                                                !data.changed
                                        "
                  />
                  <el-button
                    class="col-md-12 col-12"
                    v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                    @click="
                                            clickGenerateGuie(data.id, '80')
                                        "
                  >Guia</el-button>
                  <br
                    v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                  />
                  <template v-if="configuration.caja_actions && configuration.internal_voided">
                    <el-button
                      class="col-md-12 col-12"
                      v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id != '13'
                                            "
                      @click="clickVoidedNote(data)"
                    >Anular internamente</el-button>
                  </template>
                  <template v-if="data.paid == 0 && !data.is_credit">
                    <br />
                    <el-button
                      class="col-md-12 col-12"
                      @click="
                                                clickPaymentSaleNotes(data.id)
                                            "
                    >Pagos</el-button>
                  </template>
                </div>
              </div>
            </td>

            <td
              :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
            >
              <template v-if="type == 'quotations'">
                <div class="dropdown-as-select d-inline-block" data-childselector="span">
                  <button
                    v-if="data.state_type_id != '11'"
                    class="btn p-0"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <span
                      class="btn btn-primary dropdown-toggle"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      data-bs-delay="0"
                      title
                      data-bs-original-title="Item Count"
                      aria-label="Item Count"
                    >
                      <i class="fas fa-list"></i>
                    </span>
                  </button>

                  <div class="dropdown-menu dropdown-menu-end col-md-2 col-1">
                      <el-button v-if="!configuration.maderera"
                        class="col-md-12 col-12"
                        @click="clickEditQuotation(data.id)"
                      >Editar
                      </el-button>
                    <!-- </template> -->
                    <br />
                    <el-button
                      v-if="
                                                data.document_type_id == '01' &&
                                                    data.state_type_id == '05'
                                            "
                      class="col-md-12 col-12"
                      @click="
                                                clickAnulateQuotation(data.id)
                                            "
                    >Anular</el-button>
                    <br
                      v-if="
                                                data.document_type_id == '01' &&
                                                    data.state_type_id == '05'
                                            "
                    />
                    <el-button
                      v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id != '13'
                                            "
                      class="col-md-12 col-12"
                      @click="clickOpenWhatsapp(data)"
                    >Enviar whatsapp</el-button>
                    <br
                      v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id != '13'
                                            "
                    />
                    <el-button
                      v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id !=
                                                        '13' &&
                                                    configuration.print_document_cash
                                            "
                      class="col-md-12 col-12"
                      @click="
                                                print(
                                                    data.external_id,
                                                    data.document_type_id
                                                )
                                            "
                    >Imprimir</el-button>
                    <br
                      v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id !=
                                                        '13' &&
                                                    configuration.print_document_cash
                                            "
                    />
                    <el-button
                      class="col-md-12 col-12"
                      @click="
                                                previsualitation(
                                                    data.external_id,
                                                    data.document_type_id
                                                )
                                            "
                    >Previsualización</el-button>
                    <br />
                  </div>
                </div>
                <el-tooltip v-if="!data.changed" content="Generar documento">
                  <el-button
                    size="mini"
                    style="margin-bottom:3px;"
                    @click="clickOptionsQuotation(data.id)"
                  >
                    <i class="fas fa-file-import"></i>
                  </el-button>
                </el-tooltip>
                <!-- <el-tooltip content="Generar documento">
                                    <el-button
                                        size="mini"
                                        style="margin-bottom:3px;"
                                        @click="clickOptionsQuotation(data.id)"
                                    >
                                        <i class="fas fa-file-import"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Editar">
                                    <el-button
                                        size="mini"
                                        style="margin-bottom:3px;"
                                        @click="clickEditQuotation(data.id)"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Anular">
                                    <el-button
                                        @click="clickAnulateQuotation(data.id)"
                                        type="danger"
                                        size="mini"
                                        style="margin-bottom:3px;"
                                    >
                                        <i class="fas fa-ban"></i>
                                    </el-button>
                </el-tooltip>-->
              </template>
              <template v-if="type !== 'quotations'">
                <el-button
                  v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                  size="mini"
                  type="success"
                  style="margin-bottom:3px;"
                  @click="clickOpenWhatsapp(data)"
                >
                  <el-tooltip
                    class="item"
                    effect="dark"
                    content="Enviar a WhatsApp"
                    placement="top-start"
                  >
                    <i class="fab fa-whatsapp fa-lg" aria-hidden="true"></i>
                  </el-tooltip>
                </el-button>

                <el-button
                  type="primary"
                  v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13' &&
                                            configuration.print_document_cash
                                    "
                  size="mini"
                  plain
                  @click="
                                        print(
                                            data.external_id,
                                            data.document_type_id
                                        )
                                    "
                >
                  <el-tooltip
                    class="item"
                    effect="dark"
                    content="Reimprimir Documento"
                    placement="top-start"
                  >
                    <i class="fas fa-print text-white fa-lg"></i>
                  </el-tooltip>
                </el-button>
                <el-button
                  type="danger"
                  size="mini"
                  plain
                  @click="
                                        previsualitation(
                                            data.external_id,
                                            data.document_type_id
                                        )
                                    "
                >
                  <el-tooltip
                    class="item"
                    effect="dark"
                    content="Previsualización de pdf (Descargar)"
                    placement="top-start"
                  >
                    <i class="far fa-file-pdf text-white fa-lg"></i>
                  </el-tooltip>
                </el-button>
              </template>
            </td>
            <td
              v-if="
                                configuration.restaurant &&
                                    (type == 'documents' || type == 'saleNotes')
                            "
            >
              {{ data.table_number }}
              <br />
              <template>
                <small>
                  <span class="">{{ data.ordens_ref }}</span>
                </small>
              </template>
            </td>
            <td
              :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
            >
              <template v-if="type == 'saleNotes'">{{ data.full_number }}</template>
              <template v-if="type == 'documents'">{{ data.number }}</template>
              <template v-if="type == 'quotations'">{{ data.identifier }}</template>
            </td>
            <td
              :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
            >
              {{ data.date_of_issue }}
              <br />
              <small>{{ data.time_of_issue }}</small>
            </td>

            <td
              :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
            >
              {{ data.customer_name }}
              <br />
              <span class="text-muted">
                {{
                data.customer_number
                }}
              </span>
              <template v-if="type == 'saleNotes' && data.variation">
                <br />
                <small>
                  <span>
                    {{ data.variation.series }}-{{
                    data.variation.number
                    }}
                    /
                  </span>
                  <span>{{ data.variation.customer.name }}</span>
                  <span>
                    {{
                    data.variation.customer.number
                    }}
                  </span>
                </small>
              </template>
            </td>
            <td v-if="type == 'quotations'">{{ data.user_name }}</td>
            <td v-if="type == 'quotations'">
              <template v-if="data.documents.length > 0">{{ data.documents[0].number_full }}</template>
              <template v-if="data.sale_notes.length > 0">{{ data.sale_notes[0].identifier }}</template>
              <!-- {{ data.user_name }} -->
            </td>
            <td v-if="type == 'documents'">
              <template v-for="(row, index) in data.sale_note_related" >
                <small class="d-block" :key="index">
                  {{
                  row.number
                  }}
                </small>
              </template>
            </td>
            <td
              :class="
                                `${
                                    data.state_type_description == 'Aceptado'
                                        ? 'text-success'
                                        : data.state_type_description ==
                                              'Anulado' ||
                                          data.state_type_description ==
                                              'Por anular'
                                        ? 'text-white'
                                        : data.state_type_description ==
                                          'Enviado'
                                        ? 'text-primary'
                                        : 'text-black'
                                }`
                            "
            >
              <b>{{ data.state_type_description }}</b>
            </td>
            <td
              v-if="type == 'documents'"
              class="text-warning"
            >{{ data.remain > 0 ? data.remain : "" }}</td>
            <td
              v-if="type == 'saleNotes'"
              class="text-warning"
            >{{ data.pending > 0 ? data.pending.toFixed(2) : "" }}</td>
            <td
              :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
            >{{ data.total }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <el-pagination
      @current-change="getRecords"
      layout="total, prev, pager, next"
      :total="pagination.total"
      :current-page.sync="pagination.current_page"
      :page-size="pagination.per_page"
    ></el-pagination>
    <!-- <br /><br /><br /><br />
        <br />
    <br />-->
    <whatsapp-modal
      :documentNumber="currentNumber"
      :company="company"
      :documentId="currentId"
      :documentTypeId="currentType"
      :showDialog.sync="showWhatsappModal"
      :sender="sender"
      :establishment.sync="establishment"
    ></whatsapp-modal>

    <template v-if="type == 'quotations'">
      <quotation-options
        :showDialog.sync="showDialogOptions"
        :recordId="quotationId"
        :showGenerate="true"
        :showClose="true"
      ></quotation-options>
      <quotation-edit-modal :showDialog.sync="showEditQuotationDialog" :recordId="quotationId"></quotation-edit-modal>
    </template>
    <document-print-previsualitation
      :resource="resourcePdf"
      :showDialog.sync="showPrevisualitation"
    ></document-print-previsualitation>

    <sale-note-generate
      :configuration="configuration"
      :showDialog.sync="showDialogGenerate"
      :recordId="currentId"
      :showGenerate="true"
      :showClose="false"
      :fromCaja="true"
      @getRecords="getRecords"
    ></sale-note-generate>
    <create-dispatch
      :showDialog.sync="showCreateDispatch"
      :type="currentType"
      :recordId="currentId"
      :configuration="configuration"
    ></create-dispatch>

    <documents-voided
      :external="true"
      @getRecords="getRecords"
      :showDialog.sync="showDialogVoided"
      :recordId="recordId"
    ></documents-voided>
    <documents-payments
      @getRecords="getRecords"
      :external="true"
      :showDialog.sync="showDialogPayments"
      :documentId="recordId"
    ></documents-payments>
    <sale-note-payments
      :configuration="configuration"
      :showDialog.sync="showDialogPaymentsSaleNotes"
      :documentId="recordId"
    ></sale-note-payments>

    <note-modal
      :configuration="configuration"
      :showDialog.sync="showNoteModal"
      :recordId.sync="recordId"
      @getRecords="getRecords"
    ></note-modal>
    <el-dialog
      :visible.sync="showDialogReasonToAvoid"
      width="50%"
      :title="titleAvoidSaleNote"
      :close-on-click-modal="false"
      append-to-body
    >
      <div class="row m-2">
        <el-input
          v-model="reasonToAvoid"
          type="textarea"
          :autosize="{ minRows: 3, maxRows: 10 }"
          placeholder="Motivo de anulación"
        ></el-input>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="showDialogReasonToAvoid = false">Cancelar</el-button>
        <el-button type="primary" @click="clickAnulateSaleNoteCredit()">Anular</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
const DocumentsVoided = () =>
  import(
    "../../../../../../../../resources/js/views/documents/partials/voided.vue"
  );
const DocumentsPayments = () =>
  import(
    "../../../../../../../../resources/js/views/documents/partials/payments.vue"
  );
import whatsappModal from "./whatsapp_modal.vue";
import { deletable } from "../../../../../../../../resources/js/mixins/deletable";
const DocumentPrintPrevisualitation = () =>
  import("./document_print_previsualitation.vue");
const QuotationEditModal = () => import("./quotation_edit_modal.vue");
const QuotationOptions = () =>
  import(
    "../../../../../../../../resources/js/views/quotations/partials/options.vue"
  );
const SaleNoteGenerate = () =>
  import(
    "../../../../../../../../resources/js/views/sale_notes/partials/option_documents.vue"
  );
const CreateDispatch = () => import("./create_dispatch.vue");
const NoteModal = () => import("./note_modal.vue");
const SaleNotePayments = () =>
  import(
    "../../../../../../../../resources/js/views/sale_notes/partials/payments.vue"
  );
export default {
  components: {
    whatsappModal,
    QuotationOptions,
    QuotationEditModal,
    DocumentPrintPrevisualitation,
    SaleNoteGenerate,
    CreateDispatch,
    DocumentsVoided,
    DocumentsPayments,
    NoteModal,
    SaleNotePayments
  },
  mixins: [deletable],
  props: [
    "records",
    "pagination",
    "type",
    "company",
    "sender",
    "establishment",
    "configuration"
  ],
  data() {
    return {
      showDialogPaymentsSaleNotes: false,
      titleAvoidSaleNote: "Motivo de anulación",
      resourcePdf: null,
      showPrevisualitation: false,
      loading: false,
      showWhatsappModal: false,
      currentId: null,
      currentType: null,
      currentNumber: null,
      showDialogOptions: false,
      recordId: null,
      quotationId: null,
      showDialogVoided: false,
      showEditQuotationDialog: false,
      showDialogGenerate: false,
      currentType: null,
      showCreateDispatch: false,
      showDialogPayments: false,
      showNoteModal: false,
      showDialogReasonToAvoid: false,
      reasonToAvoid: null
    };
  },

  methods: {
    clickAnulateSaleNoteCredit() {
      if (this.reasonToAvoid == null || this.reasonToAvoid == "") {
        this.$toast.error("Debe introducir un motivo de anulación");
        return;
      }
      this.anular(
        `/sale-notes/anulate/${this.currentId}?reason_to_void=${this.reasonToAvoid}`
      ).then(() => {
        this.showDialogReasonToAvoid = false;
        this.$emit("getRecords");
      });
    },
    showDialogAvoid(id) {
      this.currentId = id;
      this.showDialogReasonToAvoid = true;
      this.reasonToAvoid = null;
    },
    clickVoidedNote(data) {
      let id = data.id;
      let is_credit = data.is_credit;
      if (is_credit) {
        this.showDialogAvoid(id);
        this.titleAvoidSaleNote = "Motivo de anulación - " + data.identifier;
      } else {
        this.anular(`/sale-notes/anulate/${id}`).then(() =>
          this.$emit("getRecords")
        );
      }
    },
    clickNote(id) {
      this.recordId = id;
      this.showNoteModal = true;
    },
    clickPaymentSaleNotes(recordId) {
      this.recordId = recordId;
      this.showDialogPaymentsSaleNotes = true;
    },
    clickPayment(recordId) {
      this.recordId = recordId;
      this.showDialogPayments = true;
    },
    clickVoided(recordId) {
      this.recordId = recordId;
      this.showDialogVoided = true;
    },
    clickDeleteDocument(document_id) {
      this.destroy(`/documents/delete_document/${document_id}`).then(() =>
        this.$emit("getRecords")
      );
    },
    clickGenerateGuie(recordId, type = "03") {
      this.currentId = recordId;
      this.currentType = type;
      this.showCreateDispatch = true;
    },
    clickGenerate(recordId) {
      this.currentId = recordId;
      this.showDialogGenerate = true;
    },
    previsualitation(external_id, type) {
      let { format_printer } = this.establishment;
      let format = "";
      switch (format_printer) {
        case "1":
          format = "a4";
          break;
        case "2":
          format = "a5";
          break;
        case "3":
          format = "ticket";
          break;
        default:
          format = "ticket_50";
          break;
      }
      console.log("🚀 ~ previsualitation ~ format:", format);
      let url = null;
      if (type == "80") {
        url = `/sale-notes/print/${external_id}/${format}`;
      } else if (type == "03" || type == "01" || type == "07" || type == "08") {
        url = `/print/document/${external_id}/${format}`;
      } else {
        url = `/quotations/print/${external_id}/${format}`;
      }
      this.resourcePdf = url;
      this.showPrevisualitation = true;
    },
    clickAnulateQuotation(id = null) {
      this.anular(`/quotations/anular/${id}`).then(
        () => this.$emit("getRecords")
        // this.$eventHub.$emit("reloadData")
      );
    },
    clickEditQuotation(recordId = null) {
      this.quotationId = recordId;
      this.showEditQuotationDialog = true;
    },
    async clickOptionsQuotation(recordId = null) {
      this.quotationId = recordId;
      let quotation = this.records.find(it => it.id == recordId);
      let customer_number = quotation ? quotation.customer_number : null;
      try {
        this.loading = true;
        const response = await this.$http(
          `/quotations/items-to-cash2/${recordId}`
        );
        if (response.status) {
          let data = response.data;
          let quotation_id = data.quotation_id;
          let identifier = data.identifier;
          if (data.items) {
            data.items.forEach(it => {
              this.$emit(
                "insertOrden",
                it,
                quotation_id,
                identifier,
                customer_number
              );
              this.$emit("closeDialog");
            });
          }
          // if (data.orden) {
          //     let orden = data.orden;
          //     orden.quotation_id = recordId;
          //     orden.cot = data.cot;
          //     this.$emit("sendOrdens", data.orden);
          //     this.$emit("closeDialog");
          // }
        }
      } catch (e) {
        this.$toast.error("Error al obtener los items de la cotización");
      } finally {
        this.loading = false;
      }
      // this.showDialogOptions = true;
    },
    clickOpenWhatsapp(record) {
      console.log(this.establishment, " mode");
      this.showWhatsappModal = true;
      this.currentId = record.id;
      this.currentType = record.document_type_id || "COT";
      if (this.type == "saleNotes") {
        this.currentNumber = record.full_number;
      } else if (this.type == "documents") {
        this.currentNumber = record.number;
      } else {
        this.currentNumber = record.identifier;
      }
    },
    async clickSendOnline(document_id) {
      try {
        this.loading = true;
        const response = await this.$http.get(`/documents/send/${document_id}`);

        if (response.data.success) {
          this.$toast.success("Se envio satisfactoriamente el comprobante.");
          this.$eventHub.$emit("reloadData");

          // this.clickCheckOnline(document_id);
        } else {
          this.$toast.error(response.data.message);
        }
      } catch (error) {
        this.$toast.error(error.response.data.message);
      } finally {
        this.loading = false;
      }
    },
    async clickReStore(document_id) {
      try {
        this.loading = true;
        const response = await this.$http.get(
          `/documents/re_store/${document_id}`
        );
        console.log(response);
        if (response.data.success) {
          this.$toast.success(response.data.message);
        } else {
          this.$toast.error(response.data.message);
        }
      } catch (error) {
        this.$toast.error(error.response.data.message);
      } finally {
        this.loading = false;
      }
    },

    async clickValidarCpe(document_id) {
      try {
        this.loading = true;
        const response = await this.$http.get(
          `/documents/validate/${document_id}`
        );

        if (response.data.success) {
          this.$toast.success(response.data.message);
          this.$emit("getRecords", this.pagination.current_page);
        } else {
          this.$toast.error(response.data.message);
        }
      } catch (error) {
        this.$toast.error(error.response.data.message);
      } finally {
        this.loading = false;
      }
    },
    getRecords() {
      this.$emit("getRecords", this.pagination.current_page);
    },
    print(external_id, type) {
      this.$emit("printData", external_id, type);
    }
  }
};
</script>
