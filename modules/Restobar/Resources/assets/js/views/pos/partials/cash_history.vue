<!-- Historial caja - POS principal -->
<template>
    <el-dialog
        v-loading="loading"
        :visible="showHistoryCash"
        @open="open"
        @close="close"
        :title="title"
        width="75%"
    >
            <!-- Filtros de búsqueda -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <el-input v-model="searchCode" placeholder="Buscar por código" clearable></el-input>
                </div>
                <div class="col-md-3">
                    <el-date-picker
                        v-model="searchDate"
                        type="date"
                        placeholder="Buscar por fecha"
                        format="yyyy-MM-dd"
                        value-format="yyyy-MM-dd"
                        clearable
                    ></el-date-picker>
                </div>
                <!-- <div class="col-md-2">
                    <el-button type="primary" @click="getRecords">Buscar</el-button>
                </div> -->
            </div>
        <div class="card container table-responsive col-md-12">
            <table class="table table-hover table-striped table-condensed table-bordered table-responsive"style="width:100%; white-space: nowrap;">
                <thead style="background-color: #073f68; color: #fff;">
                    <tr>
                        <th style="color: #fff; width: 10px; text-align: center;">#</th>
                        <th style="color: #fff; width: 50px; text-align: center;">Código</th>
                        <th style="color: #fff; width: 200px;">Turno</th>
                        <th style="color: #fff; width: 120px; text-align: center;">S/ Apertura</th>
                        <th style="color: #fff; width: 120px; text-align: right;">S/ Cierre</th>
                        <th style="color: #fff; width: 120px; text-align: center;">F.Cierre</th>
                        <th style="color: #fff; width: 250px; text-align: center;">Reporte</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(box, idx) in filteredBoxes" :key="idx" :style="{ backgroundColor: idx % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                        <td>
                           <!-- {{ idx + 1 }} -->
                            {{ customIndex(idx) }}
                        </td>
                        <td class="text-center">{{ box.id }}</td>
                        <td>   
              {{ (() => {
                // box.date_opening may come as 'YYYY-MM-DD' (no timezone)
                // new Date('YYYY-MM-DD') is treated as UTC by some browsers,
                // which can show the previous day depending on local TZ.
                // To avoid that, parse 'YYYY-MM-DD' into a local Date.
                const raw = box.date_opening;
                let date;
                if (typeof raw === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(raw)) {
                  const parts = raw.split('-').map(Number);
                  // year, monthIndex (0-based), day
                  date = new Date(parts[0], parts[1] - 1, parts[2]);
                } else {
                  // Fallback: try native parsing for full datetimes or other formats
                  date = new Date(raw);
                }
                if (!(date instanceof Date) || isNaN(date.getTime())) {
                  return '';
                }
                const options = { weekday: 'long', day: 'numeric', month: 'long' };
                let str = date.toLocaleDateString('es-ES', options);
                // Capitalize first letter
                str = str.charAt(0).toUpperCase() + str.slice(1);
                // Remove comma and "de"
                str = str.replace(/,|\sde\s/g, ' ');
                // Remove extra spaces
                str = str.replace(/\s+/g, ' ').trim();
                return str;
              })() }}
                                <br />
                              {{`${box.reference_number || "SIN REFERENCIA"}`}}
                        </td>
                        <td class="text-right">
                            {{ Number(box.beginning_balance).toFixed(2) }}
                        </td>
                        <td>
                            {{ box.date_closed || "Caja Abierta" }}
                        </td>
                        <td class="text-center">
                            <el-button
                                type="success"
                                class="text-white"
                                :style="{ backgroundColor: '#388e3c', borderColor: '#388e3c' }"
                                @click="getFinalBalance(box.id, idx)"
                            >
                                <i v-if="box.final_balance == 0" class="fas fa-eye" style="font-size: 1.5em;"></i>
                                <span v-if="box.final_balance > 0" style="font-weight: bold; font-size: 1.5em; color: #fff;">
                                    {{ box.final_balance.toLocaleString('es-PE', { minimumFractionDigits: 2 }) }}
                                </span>
                            </el-button>
                        </td>
                        <td>
                            <!-- Botones de Reportes historial -->
                            <div style="display: flex; flex-wrap: wrap; gap: 4px; align-items: center;">
                              <template v-if="box.is_loading_report">
                              <el-button class="btn_guardarsmall" type="primary" disabled
                                   style="margin:0; padding:3px 6px; min-width:auto; height:28px; font-size:12px;">
                                <i class="el-icon-loading" style="font-size:14px"></i>
                                <span style="font-size:12px; margin-left:6px;">Generando reportes</span>
                              </el-button>
                              </template>
                              <template v-else>
                              <el-button
                                type="success"
                                class="btn_whatsappsmall"
                                @click="openWhastappForm(box)"
                                style="margin:0; padding:4px 6px; min-width:40px !important; height:28px; font-size:12px;">
                                <i class="fab fa-whatsapp" aria-hidden="true" style="font-size:14px"></i>
                              </el-button>
                              <el-button
                                :class="box.has_ticket ? 'btn_guardarsmall' : 'btn_cancelarsmall'"
                                @click="openDetail(box, idx)"
                                style="margin:0; padding:4px 8px; min-width:40px !important; height:28px; font-size:12px;"
                              >
                                Ver
                              </el-button>
                              <el-button
                                :class="box.has_ticket_usd ? 'btn_guardarsmall' : 'btn_cancelarsmall'"
                                v-if="configuration.other_currency_pos"
                                @click="openDetailUsd(box, idx)"
                                style="margin:0; padding:4px 8px; min-width:40px !important; height:28px; font-size:12px;"
                              >
                                Ver $
                              </el-button>
                              <el-button
                                :class="box.has_ticket ? 'btn_guardarsmall' : 'btn_cancelarsmall'"
                                @click="openA4(box, idx)"
                                style="margin:0; padding:4px 8px; min-width:40px !important; height:28px; font-size:12px;"
                              >
                                A4
                              </el-button>
                              <!-- A4 $ -->
                              <el-button
                                :class="box.has_a4_usd ? 'btn_guardarsmall' : 'btn_cancelarsmall'"
                                v-if="configuration.other_currency_pos"
                                @click="openA4Usd(box, idx)"
                                style="margin:0; padding:4px 8px; min-width:40px !important; height:28px; font-size:12px;"
                              >
                                A4 $
                              </el-button>
                              </template>
                              
                              <el-tooltip
                              class="item"
                              effect="dark"
                              content="Reporte de los yapes realziados en la caja"
                              placement="top">
                              <el-button class="btn_yapesmall" type="primary"
                                v-if="configuration.yape_report"
                                :style="{ backgroundColor: '#7F3FBF', borderColor: '#7F3FBF', color: 'white', padding: '4px 6px', height: '28px', fontSize: '12px' }"
                                @click="openYape(box)"
                              >
                                YAPE
                              </el-button>
                              </el-tooltip>
                              <el-tooltip
                              class="item"
                              effect="dark"
                              content="Borrar reporte"
                              placement="top">
                              <el-button
                                class="btn_cancelarsmall"
                                type="danger"
                                @click="deleteReport(box)"
                                style="margin:0; padding:4px 6px; min-width:40px !important; height:28px; font-size:12px;"
                              >
                                <i class="el-icon-delete" style="font-size:14px"></i>
                              </el-button>
                              </el-tooltip>
                              <el-tooltip
                              v-if="box.tab_single"
                              class="item"
                              effect="dark"
                              content="Reporte tabulado"
                              placement="top">
                              <el-button class="btn_guardarsmall" type="primary"
                                icon="el-icon-download"
                                circle
                                v-if="box.stock_file"
                                @click="openSaludSingle(box.id)"
                                style="margin:0; min-width:40px !important; height:28px; padding:0; font-size:12px;">
                              </el-button>
                              </el-tooltip>
                              <el-tooltip
                              class="item"
                              effect="dark"
                              content="Descargar Excel del stock al momento de cerrar caja"
                              placement="top">
                              <el-button
                                class="btn_excelsmall"
                                type="success"
                                circle
                                v-if="box.stock_file"
                                @click="openExcel(box)"
                                style="display: flex; align-items: center; justify-content: center; margin:0; min-width:40px !important; height:28px; padding:0; font-size:12px;">
                                <i class="icofont-file-excel" style="font-size:14px; margin: 0;"></i>
                              </el-button>
                              </el-tooltip>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination
                @current-change="getRecords"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="Number(pagination.per_page)"
            >
            </el-pagination>
        </div>
        <br />

        <cash-modal
            v-if="currentBox"
            :cash.sync="currentBox"
            :area_id="area_id"
            :showDetail.sync="showDetail"
        ></cash-modal>
        <el-dialog
            append-to-body
            width="40%"
            title="Enviar reporte por whatsapp"
            :visible.sync="showWhatsappForm"
        >
            <div
                class="p-3"
                v-loading="loading"
                element-loading-text="Enviando.."
            >
                <label for="">Número</label>
                <el-input v-model="number" style="width:100%"></el-input>
                <div class="d-flex justify-content-end p-1">
                    <el-button @click="sendWhatsapp">Enviar</el-button>
                </div>
            </div>
        </el-dialog>
        <el-dialog
            append-to-body
            width="40%"
            title="Detalle"
            :visible.sync="showFrame"
        >
            <iframe
                :src="currentUrlBox"
                frameborder="0"
                style="width:100%;height:550px"
            ></iframe>

            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="print">Imprimir</el-button>
                <el-button @click="showFrame = false">Cerrar</el-button>
            </span>
        </el-dialog>
    </el-dialog>
</template>

<script>
import queryString from "query-string";
import CashModal from "./cash_modal.vue";
import { parseLocalDateFromYYYYMMDD, formatDateLongES } from '../../../../../../../../resources/js/utils/date';
export default {
  components: { CashModal },
  props: ["showHistoryCash", "cash_id", "area_id", "sender", "configuration"],
  data() {
    return {
      boxes: [],
      pagination: {},
      number: null,
      loading: false,
      title: "Sin registros",
      showDetail: false,
      currentBox: null,
      showWhatsappForm: false,
      message: null,
      resource: null,
      currentUrlBox: null,
      showFrame: false,
      searchCode: '',
      searchDate: ''

    };
  },
  computed : {
    filteredBoxes() {
      return this.boxes.filter(box => {
        const date = parseLocalDateFromYYYYMMDD(box.date_opening);
        if (this.searchCode && !String(box.id).includes(this.searchCode)) {
          return false;
        }
        if (this.searchDate && box.date_opening !== this.searchDate) {
          return false;
        }
        return true;
      });
    }
  },
  methods: {
    customIndex(idx) {
      return (
        this.pagination.per_page * (this.pagination.current_page - 1) +
        idx +
        1
      );
    },
        async print() {
      try {
        this.loadingPrint = true;
        const response = await this.$http(
          `cash/get_printer/${this.area_id}`
        );
        let {
          data: { printer }
        } = response;
        let config = qz.configs.create(printer, {
          scaleContent: false
        });
        if (!qz.websocket.isActive()) {
          await qz.websocket.connect(config);
        }
        let isPosd = printer.split(" ")[printer.split(" ").length - 1];
        if (isPosd == "POSD") {
          config.density = 200;
        }
        let data = [
          {
            type: "pdf",
            format: "file",
            data: this.currentUrlBox
          }
        ];
        await qz.print(config, data);
      } catch (e) {
        this.$toast.error(e.message);
      } finally {
        this.loadingPrint = false;
      }
    },
    openDetail(box, idx) {
      if (box.has_ticket) {
        this.showFrame = true;
        this.currentUrlBox = box.path_ticket_url;
      } else {
        this.generateReports(box.id, idx);
      }
    },
    openDetailUsd(box, idx) {
      if (box.has_ticket_usd) {
        this.showFrame = true;
        this.currentUrlBox = box.path_ticket_url_usd;
      } else {
        this.generateReports(box.id, idx);
      }
    },
    getFinalBalance(id, idx) {
      this.$http(`/caja/worker/cash/get-final-balance/${id}`).then(
        response => {
          if (response.status == 200) {
            this.$toast.success(
              `Saldo final: ${response.data.final_balance}`
            );
            this.boxes[idx].final_balance =
              response.data.final_balance;
          }
        }
      );
    },
    generateReports(id, idx) {
      this.loading = true;
      this.boxes[idx].is_loading_report = true;
      this.$http(`/caja/worker/cash/generate_reports/${id}`)
        .then(response => {
          if (response.status == 200) {
            this.$toast.success(
              "Se están generando los reportes, espere un momento por favor"
            );
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    openSaludSingle(id) {
      window.open(`/caja/report-boxes/cashes_salud_single?cash_id=${id}`);
    },
    openExcel(cash) {
      let { id } = cash;
      window.open(`/get_stock_file/${id}`);
    },
    openWhastappForm(cash) {
      this.number = null;
      this.message = `Reporte de ${cash.user} ${cash.date_opening}`;
      this.resource = `/caja/report-boxes/reports_resumen_type?cash_id=${cash.id}`;
      this.showWhatsappForm = true;
    },
    async sendWhatsapp() {
      if (!this.number || this.number.length != 9 || isNaN(this.number)) {
        return this.$toast.error("Ingrese un número válido");
      }
      this.loading = true;
      try {
        const response = await this.$http.post("/whatsapp/historial", {
          number: this.number,
          sender: this.sender,
          message: this.message,
          resource: this.resource,
          file_name: this.message.split(" ").join("-")
        });
        if (response.status == 200) {
          this.$toast.success("Mensaje enviado");
        }
      } catch (e) {
        this.$toast.error("Mensaje no enviado");
        console.log(e);
      } finally {
        this.showWhatsappForm = false;
        this.loading = false;
      }
    },
    openA4(cash, idx) {
      if (cash.has_a4) {
        window.open(
          `/caja/report-boxes/reports_resumen_type?cash_id=${cash.id}`
        );
      } else {
        this.generateReports(cash.id, idx);
      }
    },
    openYape(cash, idx) {
      if (cash.has_a4) {
        window.open(
          `/caja/report-boxes/reports_resumen_yape?cash_id=${cash.id}`
        );
      } else {
        this.generateReports(cash.id, idx);
      }
    },
    openA4Usd(cash, idx) {
      if (cash.has_a4) {
        window.open(
          `/caja/report-boxes/reports_resumen_type_usd?cash_id=${cash.id}`
        );
      } else {
        this.generateReports(cash.id, idx);
      }
    },
    deleteReport(cash) {
      this.loading = true;
      this.$http
        .delete(`/caja/report-boxes/delete-report/${cash.id}`)
        .then(response => {
          if (response.status == 200) {
            this.$toast.success("Reportes eliminados");
            cash.has_a4 = false;
            cash.has_a4_usd = false;
            cash.has_ticket = false;
            cash.has_ticket_usd = false;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    seeDetail(cash) {
      this.currentBox = cash;
      this.showDetail = true;
    },
    getQueryParameters() {
      const params = {
        page: this.pagination.current_page,
        from_cash: true
      };
      if (this.searchCode) params.code = this.searchCode;
      if (this.searchDate) params.date = this.searchDate;
      return queryString.stringify(params);
    },
    async getRecords() {
      let query = this.getQueryParameters();
      try {
        this.loading = true;
        const response = await this.$http(`cash/records?${query}`);
        if (response.status == 200) {
          const { data, meta } = response.data;
          this.boxes = data;
          console.log(data);
          if (this.boxes.length != 0) {
            this.title = `Usuario: ${this.boxes[0].user}`;
          }
          this.pagination = meta;
        }
      } catch (e) {
        this.$toast.error("Ocurrió un erro");
      } finally {
        this.loading = false;
      }
    },
    async open() {
      await this.getRecords();
      console.log("la configuracion", this.configuration);
    },
    close() {
      this.$emit("update:showHistoryCash");
    }
  }
}
</script>
