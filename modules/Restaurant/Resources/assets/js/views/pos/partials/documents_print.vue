<template>
  <el-dialog
    :visible="showDialog"
    append-to-body
    @close="close"
    @open="open"
    width="85%"
    v-loading="loading"
    title="Comprobantes"
    :close-on-click-modal="false"
    :show-close="false"
  >
    <div class="data-table-visible-columns">
      <div class="d-flex align-items-center">
        <el-button
            v-if="activeName == 'saleNotes'"
            type="button"
            class="btn_buscar"
            style="margin-right: 5px; font-size: 12px; padding: 5px 10px;"
            href="javascript:void(0)"
            @click.prevent="onOpenModalGenerateCPE"
        >
            <i
              class="fas fa-exchange-alt fa-sm icon-style"
              title="Convertir documentos"
            ></i>
            CPE -A->> NV
        </el-button>
        
        <el-button
          v-if="config.health_network && establishment.is_product"
          type="button"
          class="btn_buscar"
          style="margin-right: 5px;"
          href="javascript:void(0)"
          @click.prevent="clickDocumentSalud()"
        >
          <i class="icofont-plus-circle"></i>
          Documentos Farmacia
        </el-button>

        <el-button
          type="danger"
          icon="el-icon-close"
          circle
          style="margin-left: auto; color: white; background-color: red; border-color: red;"
          @click="close"
        ></el-button>
        
      </div>
    </div>

      <div class>
        <div class="row mb-3" style="margin-top: 0; margin-bottom: 0;">
          <!-- Left Column (70%) -->
          <div class="col-12 col-md-7 d-flex align-items-stretch">
            <div class="card p-3 w-100">
              <div class="row">
          <div class="col-12 col-md-4 mb-2 mb-md-0">
            <label for="typeSearch">Filtro</label>
            <el-select id="typeSearch" v-model="typeSearch" class="w-100">
              <el-option value="document" label="N° Documento (CPE)"></el-option>
              <el-option value="client" label="Nombre de Cliente/Empresa"></el-option>
              <el-option value="date" label="Fecha de Emisión CPE"></el-option>
            </el-select>
          </div>

          <div class="col-12 col-md-8">
            <label for="argumentInput" class="form-label fw-bold">
              Argumento <span class="text-muted">(DNI/RUC - Fecha - Cliente)</span>
            </label>
            <el-input
              id="argumentInput"
              v-if="typeSearch != 'date'"
              v-model="value"
              @input="getRecordsInput"
              placeholder="Ingrese el argumento"
              class="text-muted w-100"
              clearable
            ></el-input>
            <el-date-picker
              v-else
              v-model="value"
              @change="getRecordsInput"
              value-format="yyyy-MM-dd"
              placeholder="Seleccione una fecha"
              class="w-100"
              clearable
            ></el-date-picker>
          </div>
              </div>
            </div>
          </div>

          <!-- Right Column (30%) -->
            <div class="col-12 col-md-5 d-flex align-items-stretch">
              <div class="card p-3 w-100">
                <div class="row">
                  <!-- Saldos Pendientes -->
                  <div class="col-4">
                  <div>
                    <div class="col-12">
                    <div class="text-center" v-if="activeName == 'documents'">
                      <el-checkbox 
                      v-model="remain" 
                      @change="getRecordsInput" 
                      :style="{ color: remain ? '#ffbf00 !important' : '' }"
                      >
                      Saldos
                      <i 
                        class="fas fa-exclamation-circle" 
                        style="color: red;" 
                        title="Saldos pendientes de cobro"
                      ></i>
                      </el-checkbox>
                    </div>
                    </div>
                  </div>
                  </div>

                  <!-- Ultimo CPE Emitido -->
                  <div class="col-5 d-flex justify-content-end">
                  <div class="col-12 d-flex justify-content-end">
                    <div class="d-flex flex-column align-items-end">
                    <span class="p-1 text-truncate w-100 text-end">
                      {{
                      lastDocument
                      ? lastDocument.numberPrint
                      : "No se encontró"
                      }}
                      <i 
                        class="fas fa-info-circle" 
                        style="color: #007bff;" 
                        title="Último Comprobante Emitido para este USUARIO/CAJERO"
                      ></i>
                    </span>
                    </div>
                  </div>
                  </div>

                  <!-- Boton de Imprimir -->
                  <div class="col-3 d-flex justify-content-center">
                  <div class="col-12 text-center">
                    <el-button
                    type="primary"
                    @click="
                      printData(
                      lastDocument.external_id,
                      lastDocument.document_type_id
                      )
                    "
                    >
                    <i class="fas fa-print"></i>
                    </el-button>
                  </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

        
            <el-tabs v-model="activeName" @tab-click="handleClick" style="padding-bottom: 0;">
            <!-- Notas de Venta -->
            <el-tab-pane label="Notas de venta" name="saleNotes" class="fw-bold dark-label">
              <document-print-detail
                :configuration="config"
                :company="company"
                @getRecords="getRecords"
                @printData="printData"
                :records.sync="saleNotes"
                :pagination.sync="pagination.saleNotes"
                :type="'saleNotes'"
                :sender="sender"
                :establishment.sync="establishment"
              ></document-print-detail>
            </el-tab-pane>
            <!-- Boletas Facturas -->
            <el-tab-pane v-if="company.soap_type_id != '03'" label="Facturas - Boletas: CPE" name="documents">
              <document-print-detail
                :configuration="config"
                :sender="sender"
                :company="company"
                @getRecords="getRecords"
                @printData="printData"
                :records.sync="documents"
                :pagination.sync="pagination.documents"
                :type="'documents'"
                :establishment.sync="establishment"
              ></document-print-detail>
            </el-tab-pane>
            <!-- Cotizaciones -->
            <el-tab-pane v-if="config.quotation" label="Cotizaciones" name="quotations">
              <document-print-detail
                @sendOrdens="sendOrdens"
                @closeDialog="close"
                :configuration="config"
                :sender="sender"
                :company="company"
                @insertOrden="insertOrden"
                @getRecords="getRecords"
                @printData="printData"
                :records.sync="quotations"
                :pagination.sync="pagination.quotations"
                :type="'quotations'"
                :establishment.sync="establishment"
              ></document-print-detail>
            </el-tab-pane>
            <iframe ref="pdfFrame" style="display: none;"></iframe>
          </el-tabs>
        
        <modal-generate-cpe
          :show.sync="showModalGenerateCPE"
          @sendItems="sendItems"
          @close="closeCpe"
        ></modal-generate-cpe>
        <document-salud-modal :showDialog.sync="showDialogDocumentSalud"></document-salud-modal>
      </div>
  
  </el-dialog>
</template>
<style>
.el-dialog__header {
  background-color: var(--primary) !important;
}
.el-dialog__title {
  color: var(--light-text) !important;
}
.el-dialog__headerbtn .el-dialog__close {
  color: white !important;
}
.el-tabs__item {
    font-weight: bold; /* Cambia el grosor de la fuente */
    color: #000; /* Cambia el color del texto a un color más oscuro */
}
</style>
<script>
import DocumentSaludModal from "../../../../../../../../resources/js/views/documents/partials/document_salud_modal.vue";
import DocumentPrintDetail from "./document_print_detail.vue";
import queryString from "query-string";
import ModalGenerateCpe from "./modal_generate_cpe.vue";

export default {
  components: { DocumentPrintDetail, ModalGenerateCpe, DocumentSaludModal },
  props: [
    "showDialog",
    "company",
    "sender",
    "config",
    "establishment",
    "printer",
    "area_id"
  ],
  data() {
    return {
      showDialogDocumentSalud: false,
      remain: false,
      time: null,
      loading: false,
      value: null,
      typeSearch: "document",
      saleNotes: [],
      documents: [],
      quotations: [],
      pagination: {
        saleNotes: {},
        documents: {},
        quotations: {}
      },
      lastDocument: null,
      activeName: "documents",
      showModalGenerateCPE: false
    };
  },
  methods: {
    clickDocumentSalud() {
      this.showDialogDocumentSalud = true;
    },
    sendOrdens(orden) {
      this.$emit("sendOrdens", orden);
    },
    closeCpe() {
      this.showModalGenerateCPE = false;
      this.close();
    },
    onOpenModalGenerateCPE() {
      this.showModalGenerateCPE = true;
    },
    getRecordsInput() {
      this.getRecords();
    },
    insertOrden(item, id, identifier, customer_number) {
      console.log(identifier);
      this.$emit("insertOrdenQuotation", id, identifier, item, customer_number);
    },
    sendItems(items, clientNumber, notes, dscto_global) {
      this.$emit("sendItems", items, clientNumber, notes, dscto_global);
    },
    async printEvent(url) {
      console.log(url);
      const response = await this.$http.post(`/caja/re-print`, {
        url: url
      });

      return;
      let paperConfig = {
        scaleContent: false
      };
      let partsUrl = url.split("/");
      let document = partsUrl[partsUrl.length - 1];
      let isTicket = document.toLowerCase().includes("ticket");
      let isA4 = document.toLowerCase().includes("a4");
      let isA5 = document.toLowerCase().includes("a5");
      let tipoBandejaImpresora = this.config.new_old_printer;
      if (isA4) {
        if (tipoBandejaImpresora == 1) {
          paperConfig.density = 700;
          paperConfig.orientation = "portrait";
        } else {
          paperConfig.density = 350;
          paperConfig.orientation = "portrait";
        }
      } else {
        let orientation = "portrait";
        if (isA5) {
          let { a5_orientation } = this.config;
          orientation = a5_orientation ? "landscape" : "portrait";
        }
        if (!isTicket && tipoBandejaImpresora == 1) {
          //opciones que permiten hacer una impresion correcta en impresoras nuevas
          paperConfig.density = 600;
          paperConfig.orientation = orientation;
          paperConfig.margins = { left: 2 };
        } else if (!isTicket && tipoBandejaImpresora == 0) {
          paperConfig.density = 350;
          paperConfig.orientation = orientation;
          let margins = {};
          if (orientation == "landscape") {
            margins = {
              top: 1.1,
              left: 0.95,
              right: 0.3,
              bottom: 1.1
            };
          } else {
            margins = {
              left: 1.5
            };
          }
          paperConfig.margins = margins;
        }
      }
      let isPosd = this.printer.split(" ")[this.printer.split(" ").length - 1];
      if (isPosd == "POSD" && isTicket) {
        paperConfig.density = 200;
      }
      try {
        let config = qz.configs.create(this.printer, paperConfig);
        if (!qz.websocket.isActive()) {
          await qz.websocket.connect(config);
        }
        let data = [
          {
            type: "pdf",
            format: "file",
            data: url
          }
        ];
        qz.print(config, data).catch(e => {
          this.$toast.error(e.message);
        });
      } catch (e) {}
    },
    async printData(external_id, type) {
      // console.log("🚀 ~ file: documents_print.vue:270 ~ printData ~ this.config:", this.config)
      let { reprint_whatsapp } = this.config;
      if (reprint_whatsapp) {
        this.$http
          .post(`/whatsapp/reprint/${type}/${external_id}`)
          .then(response => {
            console.log(response);
          });
      }
      let typePrint = this.establishment.format_printer;

      let url = "";
      //colocar una condicion para cada caso desde impresira de 80mm hasta las a4 y a5
      if (typePrint == "1") {
        //tamaño a4
        if (type == "80") {
          url = `/sale-notes/print/${external_id}/a4`;
        } else if (
          type == "03" ||
          type == "01" ||
          type == "07" ||
          type == "08"
        ) {
          url = `/print/document/${external_id}/a4`;
        } else {
          url = `/quotations/print/${external_id}/a4`;
        }
      }
      if (typePrint == "2") {
        //tamaño a5
        if (type == "80") {
          url = `/sale-notes/print/${external_id}/a5`;
        } else if (type == "03" || type == "01") {
          url = `/print/document/${external_id}/a5`;
        } else {
          url = `/quotations/print/${external_id}/a5`;
        }
      }
      if (typePrint == "3" || typePrint == null) {
        //tamaño 80mm
        if (type == "80") {
          url = `/sale-notes/print/${external_id}/ticket`;
        } else if (type == "03" || type == "01") {
          url = `/print/document/${external_id}/ticket`;
        } else {
          url = `/quotations/print/${external_id}/ticket`;
        }
      }
      if (typePrint == "4") {
        //tamaño 50mm
        if (type == "80") {
          url = `/sale-notes/print/${external_id}/ticket_50`;
        } else if (type == "03" || type == "01") {
          url = `/print/document/${external_id}/ticket_50`;
        } else {
          url = `/quotations/print/${external_id}/ticket_50`;
        }
      }
      //console.log(config.direct_printing)

      if (this.establishment.direct_printing == 0) {
        window.open(url, "_blank");
      } else {
        let userAgent = navigator.userAgent;
        let isFirefox = userAgent.indexOf("Firefox") != -1;
        if (isFirefox) {
          const pdfUrl = url;
          console.log("🚀 ~ printData ~ url:", url);
          const pdfFrame = this.$refs.pdfFrame;
          pdfFrame.src = pdfUrl;
          pdfFrame.onload = () => {
            pdfFrame.contentWindow.print();
          };
        } else {
          await this.printEvent(url);
        }
        // await this.printEvent(url);
        console.log(navigator.userAgent);
      }
    },
    async getLastDocument() {
      try {
        this.loading = true;
        const response = await this.$http(`/caja/worker/print_last_document`);

        if (response.status == 200) {
          const {
            data: { document }
          } = response;
          this.lastDocument = document;
          let filename = this.lastDocument.filename.split("-");
          this.lastDocument.numberPrint = filename[2] + "-" + filename[3];
        }
      } catch (e) {
        this.$toast.error("No se pudo obtener el ultimo documento");
      } finally {
        this.loading = false;
      }
    },
    async getPrinter() {
      const response = await this.$http(
        `/caja/worker/cash/get_printer/${this.area_id}`
      );

      let {
        data: { printer }
      } = response;
      this.printer = printer;
    },
    getRecords(page = 1) {
      if (this.activeName == "saleNotes") {
        this.pagination.saleNotes.current_page = Number(page);
      } else {
        this.pagination.documents.current_page = Number(page);
      }
      if (this.time) {
        clearTimeout(this.time);
      }
      this.time = setTimeout(async () => {
        await this.getLastDocuments();
      }, 500);
    },
    getQueryParameters(form = {}) {
      let page =
        this.activeName == "saleNotes"
          ? this.pagination.saleNotes.current_page
          : this.pagination.documents.current_page;
      return queryString.stringify({
        page:
          this.activeName == "saleNotes"
            ? this.pagination.saleNotes.current_page
            : this.pagination.documents.current_page,
        isNote: this.activeName == "saleNotes",
        typeDocument: this.activeName,
        column: this.typeSearch,
        value: this.value,
        remain: this.remain

        // limit: this.limit
      });
    },
    handleClick() {
      this.remain = false;
      if (
        this.saleNotes.length == 0 ||
        this.documents.length == 0 ||
        this.quotations.length == 0
      ) {
        this.getLastDocuments();
      }
    },
    async open() {
      console.log(this.config);
      console.log(this.establishment);
      if (this.company.soap_type_id == "03") {
        this.activeName = "saleNotes";
      }
      await this.getLastDocument();
      await this.getLastDocuments();
      this.printer = this.$areaPrinter;
      console.log(this.config);
      // await this.getPrinter();
    },
    close() {
      this.$emit("update:showDialog", false);
    },

    async getLastDocuments() {
      //"/sale-notes/print/{$doc->external_id}/ticket
      //"/print/document/{$doc->external_id}/ticket";

      try {
        this.loading = true;
        const response = await this.$http(
          `/caja/worker/cash/get_last_documents?${this.getQueryParameters()}`
        );

        if (response.status != 200) {
          this.$toast.error("No se pudo imprimir");
        } else {
          const { data, meta } = response.data;
          if (this.activeName == "saleNotes") {
            this.saleNotes = data;
            this.pagination.saleNotes = meta;
          } else if (this.activeName == "quotations") {
            this.quotations = data;
            this.pagination.quotations = meta;
          } else {
            this.documents = data;
            if (this.remain) {
              this.documents = this.documents.filter(
                document => document.remain > 0
              );
            }
            this.pagination.documents = meta;
          }
        }
      } catch (e) {
        console.log(e);
        this.$toast.error("No se pudo imprimir");
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>
