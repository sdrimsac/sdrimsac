<template>
    <el-dialog v-loading="loading" :visible="showHistoryCash" @open="open" @close="close" :title="title" width="65%">
        <div class="card container table-responsive col-md-12">
            <div>
                <div class="row mb-2 align-items-end" style="margin-top: 10px; margin-left: 10px;">
                    <div class="col-md-3">
                        <el-select v-model="filterType" placeholder="Filtrar por..." style="width: 100%">
                            <el-option label="Código" value="codigo"></el-option>
                            <el-option label="Fecha de apertura" value="fecha_apertura"></el-option>
                            <el-option label="Fecha de cierre" value="fecha_cierre"></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-4">
                        <el-input v-if="filterType === 'codigo'" v-model="filterCodigo" placeholder="Ingrese código"
                            clearable></el-input>
                        <el-date-picker v-if="filterType === 'fecha_apertura'" v-model="filterFechaApertura" type="date"
                            placeholder="Seleccione fecha de apertura" format="yyyy-MM-dd" value-format="yyyy-MM-dd"
                            clearable style="width: 100%"></el-date-picker>
                        <el-date-picker v-if="filterType === 'fecha_cierre'" v-model="filterFechaCierre" type="date"
                            placeholder="Seleccione fecha de cierre" format="yyyy-MM-dd" value-format="yyyy-MM-dd"
                            clearable style="width: 100%"></el-date-picker>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-striped table-bordered table-responsive shadow-sm"
                style="width:100%; white-space: nowrap; background: #fff; border-radius: 8px; overflow: hidden;">
                <thead style="background: linear-gradient(90deg, #073f68 80%, #0a5a8c 100%); color: #fff;">
                    <tr>
                        <th style="color: #fff; text-align: center; width: 40px; min-width: 40px;">#</th>
                        <th style="color: #fff; font-weight: 600; text-align: center; width: 80px; min-width: 80px;">
                            Codigo</th>
                        <th style="color: #fff; text-align: center; width: 160px; min-width: 120px;">Turno</th>
                        <th style="color: #fff; font-weight: 600; text-align: center; width:90px; min-width: 120px;">
                            S/. Apertura</th>
                        <th style="color: #fff; font-weight: 600; text-align: center; width: 100px; min-width: 120px;">
                            Cierre</th>
                        <th style="color: #fff; font-weight: 600; text-align: center; width: 90px; min-width: 120px;">
                            Total Cierre</th>
                        <th style="color: #fff; font-weight: 600; text-align: center; width: 100px; min-width: 140px;">
                            Reporte</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(box, idx) in filteredBoxes" :key="idx" style="vertical-align: middle;">
                        <td style="text-align: center;">{{ idx + 1 }}</td>
                        <td style="text-align: center;">{{ `${box.id}` }}</td>
                        <td style="text-align: left;">
                            <div>{{ formatDate(box.date_opening) }}</div>
                            <div>{{ box.reference_number }}</div>
                        </td>
                        <td style="text-align: right;">{{ Number(box.beginning_balance).toFixed(2) }}</td>
                        <td style="text-align: center;">
                            {{ box.date_closed }}
                            <div v-if="box.time_closed">{{ box.time_closed }}</div>
                        </td>
                        <td style="text-align: right;">{{ box.date_closed ? Number(box.final_balance).toFixed(2) : "" }}
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <el-tooltip content="Enviar por WhatsApp" placement="top">
                                    <el-button type="success" size="mini" class="btn_whatsappsmall text-white" @click="openWhastappForm(box)"
                                        style="margin-right: 4px;">
                                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Descargar A4" placement="top">
                                    <!-- <el-button class="btn_guardarsmall" type="primary" size="mini" @click="openA4(box)">
                                        A4
                                    </el-button> -->
                                </el-tooltip>
                                <el-button
                                    class="margin-left:10px;"
                                    :type="
                                        `${box.has_a4 ? 'primary' : 'danger'}`
                                    "
                                    @click="openA4(box)"
                                >
                                    A4
                                </el-button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2" style="margin: 10px; width: 90%;">
                <span class="text-muted">
                    Mostrando página {{ pagination.current_page || 1 }} de {{ pagination.last_page || 1 }}
                </span>
                <el-pagination
                    background
                    @current-change="getRecords"
                    layout="total, prev, pager, next, jumper"
                    :total="pagination.total || 0"
                    :current-page.sync="pagination.current_page"
                    :page-size="pagination.per_page"
                    class="custom-pagination"
                >
                </el-pagination>
            </div>
        </div>

        <cash-modal v-if="currentBox" :cash.sync="currentBox" :area_id="area_id"
            :showDetail.sync="showDetail"></cash-modal>
        <el-dialog 
            append-to-body 
            width="30%" 
            title="Enviar Reporte" 
            :visible.sync="showWhatsappForm"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
        >
            <div class="p-3" v-loading="loading" element-loading-text="Enviando..">
            <div class="d-flex align-items-end">
                <div class="cold-8" style="flex:1; margin-right: 10px;">
                <label for="">Ingrese Número de WhatsApp</label>
                <el-input v-model="number" style="width:100%"></el-input>
                </div>
                <div class="col-2">
                <el-button @click="sendWhatsapp" class="btn_whatsappsmall">
                    <i class="fab fa-whatsapp" style="margin-right: 5px;"></i>Enviar</el-button>
                </div>
            </div>
            </div>
        </el-dialog>
    </el-dialog>
</template>

<script>
import queryString from "query-string";
import CashModal from "./cash_modal.vue";
export default {
    components: { CashModal },
    props: ["showHistoryCash", "cash_id", "area_id", "sender"],
    data() {
        return {
            boxes: [],
            pagination: {
                per_page: 20,
                current_page: 1,
                total: 0,
                last_page: 1
            },
            number: null,
            loading: false,
            title: "Sin registros",
            showDetail: false,
            currentBox: null,
            showWhatsappForm: false,
            message: null,
            resource: null,
            filterType: '',
            filterCodigo: '',
            filterFechaApertura: '',
            filterFechaCierre: ''
        };
    },
    computed: {
        filteredBoxes() {
            return this.boxes.filter(box => {
                if (this.filterType === 'codigo') {
                    return this.filterCodigo ? String(box.id).includes(this.filterCodigo) : true;
                }
                if (this.filterType === 'fecha_apertura') {
                    return this.filterFechaApertura ? (box.date_opening && box.date_opening === this.filterFechaApertura) : true;
                }
                if (this.filterType === 'fecha_cierre') {
                    return this.filterFechaCierre ? (box.date_closed && box.date_closed === this.filterFechaCierre) : true;
                }
                return true;
            });
        }
    },
    methods: {
        formatDate(dateStr) {
            if (!dateStr) return '';
            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            const d = new Date(dateStr);
            if (isNaN(d)) return dateStr;
            return `${dias[d.getDay()]} ${d.getDate()} ${meses[d.getMonth()]}`;
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
        openA4(cash) {
            window.open(
                `/caja/report-boxes/reports_resumen_type?cash_id=${cash.id}`
            );
        },
        seeDetail(cash) {
            this.currentBox = cash;
            this.showDetail = true;
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                per_page: this.pagination.per_page,
                column: "state",
                value: 0

                // limit: this.limit
            });
        },
        async getRecords() {
            let query = this.getQueryParameters();
            try {
                this.loading = true;
                const response = await this.$http(
                    `/caja/worker/cash/records_closed?${query}`
                );
                if (response.status == 200) {
                    const { data, meta } = response.data;
                    this.boxes = data;
                    if (this.boxes.length != 0) {
                        this.title = `Usuario: ${this.boxes[0].user}`;
                    }
                    // Actualiza todos los valores de paginación, forzando per_page a ser numérico
                    this.pagination = {
                        ...this.pagination,
                        ...meta,
                        per_page: Number(meta.per_page) || this.pagination.per_page,
                        current_page: Number(meta.current_page) || 1,
                        total: Number(meta.total) || 0,
                        last_page: Number(meta.last_page) || 1
                    };
                }
            } catch (e) {
                this.$toast.error("Ocurrió un erro");
            } finally {
                this.loading = false;
            }
        },
        async open() {
            await this.getRecords();
        },
        close() {
            this.$emit("update:showHistoryCash");
        },
        handleSizeChange(size) {
            this.pagination.per_page = size;
            this.pagination.current_page = 1;
            this.getRecords();
        }
    }
};
</script>
