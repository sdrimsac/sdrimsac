<!-- Historial caja - POS principal -->
<template>
    <el-dialog
        v-loading="loading"
        :visible="showHistoryCash"
        @open="open"
        @close="close"
        :title="title"
        width="90%"
    >
        <br />
        <div class="card container table-responsive col-md-12">
            <table class="table table-hover table-striped table-condensed  table-responsive"style="width:100%; white-space: nowrap;">
                <thead style="background-color: #073f68; color: #fff;">
                    <tr>
                        <th style="color: #fff;">#</th>
                        <th style="color: #fff;">Código</th>
                        <th style="color: #fff;">Turno</th>
                        <th style="color: #fff;">S/ Apertura</th>
                        <th style="color: #fff;">Cierre</th>
                        <th style="color: #fff;">S/ Cierre</th>
                        <th style="color: #fff;">Reporte</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(box, idx) in boxes" :key="idx" :style="{ backgroundColor: idx % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                        <td>
                           <!-- {{ idx + 1 }} -->
                            {{ customIndex(idx) }}
                        </td>
                        <td>{{ box.id }}</td>
                        <td>   
                            {{ (() => {
                                const date = new Date(box.date_opening);
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
                        <td>
                            {{ Number(box.beginning_balance).toFixed(2) }}
                        </td>
                        <td>
                            {{ box.date_closed || "Caja Abierta" }}
                        </td>
                        <td class="text-center">
                            <el-button
                                type="success"
                                class="text-white"
                                @click="getFinalBalance(box.id, idx)"
                            >
                                <i
                                    v-if="box.final_balance == 0"
                                    class="fas fa-eye"
                                ></i>
                                {{
                                    box.final_balance > 0
                                        ? box.final_balance
                                        : ""
                                }}
                            </el-button>
                        </td>
                        <td>
                            <template v-if="box.is_loading_report">
                                <el-button type="primary" disabled>
                                    <i class="el-icon-loading"></i>
                                    Generando reportes
                                </el-button>
                            </template>
                            <template v-else>
                                <el-button
                                    type="success"
                                    class="text-white"
                                    @click="openWhastappForm(box)"
                                >
                                    <i
                                        class="fab fa-whatsapp"
                                        aria-hidden="true"
                                    ></i>
                                </el-button>
                                <el-button
                                    :type="
                                        `${
                                            box.has_ticket
                                                ? 'primary'
                                                : 'danger'
                                        }`
                                    "
                                    @click="openDetail(box, idx)"
                                >
                                    Ver
                                </el-button>
                                <el-button
                                    v-if="configuration.other_currency_pos"
                                    :type="
                                        `${
                                            box.has_ticket_usd
                                                ? 'primary'
                                                : 'danger'
                                        }`
                                    "
                                    @click="openDetailUsd(box, idx)"
                                >
                                    Ver USD
                                </el-button>
                                <el-button
                                    class="margin-left:10px;"
                                    :type="
                                        `${box.has_a4 ? 'primary' : 'danger'}`
                                    "
                                    @click="openA4(box, idx)"
                                >
                                    A4
                                </el-button>
                                <el-button
                                    v-if="configuration.other_currency_pos"
                                    :type="
                                        `${
                                            box.has_a4_usd
                                                ? 'primary'
                                                : 'danger'
                                        }`
                                    "
                                    @click="openA4Usd(box, idx)"
                                >
                                    A4 USD
                                </el-button>
                            </template>
                            <!-- un boton para bajar un excel -->
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Descargar Excel del stock al momento de cerrar caja"
                                placement="top"
                            >
                                <el-button
                                    type="success"
                                    icon="el-icon-download"
                                    circle
                                    v-if="box.stock_file"
                                    @click="openExcel(box)"
                                ></el-button>
                            </el-tooltip>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Reporte de los yapes realziados en la caja"
                                placement="top"
                            >
                                <el-button
                                    v-if="configuration.yape_report"
                                    :style="{ backgroundColor: '#7C4DFF', borderColor: '#7C4DFF', color: 'white' }"
                                    
                                    @click="openYape(box)"
                                >
                                <i class="fas fa-file-download"></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                class="item"
                                effect="dark"
                                content="Borrar reporte"
                                placement="top"
                            >
                                <el-button
                                    type="danger"
                                    
                                    @click="deleteReport(box)"
                                >
                                <i class="el-icon-delete"></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                v-if="box.tab_single"
                                class="item"
                                effect="dark"
                                content="Reporte tabulado"
                                placement="top"
                            >
                                <el-button
                                    type="primary"
                                    icon="el-icon-download"
                                    circle
                                    v-if="box.stock_file"
                                    @click="openSaludSingle(box.id)"
                                ></el-button>
                            </el-tooltip>
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
            showFrame: false
        };
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
        /* openExcel(cash) {
            let { id } = cash;
            window.open(`/get_stock_file/${id}`);
        }, */
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
            return queryString.stringify({
                page: this.pagination.current_page,

                from_cash: true
            });
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
};
</script>
