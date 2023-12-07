<template>
    <el-dialog v-loading="loading" :visible="showHistoryCash" @open="open" @close="close" :title="title">
        <div class="card container table-responsive col-md-12">
            <table class="table table-hover table-striped table-condensed  table-responsive"   style="width:100%;     white-space: nowrap;">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>Apertura</th>
                        <th>
                            ◄ Dinero
                        </th>
                        <th>
                            Cierre
                        </th>
                        <th>
                            ◄ Dinero
                        </th>
                        <th>
                            Detalle
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(box, idx) in boxes" :key="idx">
                        <td>
                            {{ idx + 1 }}
                        </td>
                        <td>
                            {{ `${box.date_opening}/ ${box.reference_number ||'SIN REFERENCIA'}` }}
                        </td>
                        <td>
                            {{ box.beginning_balance }}
                        </td>
                        <td>
                            {{ box.date_closed || 'Sin cierre'}}
                        </td>
                        <td>
                            {{ box.date_closed ? box.final_balance.toFixed(2) : "" }}
                        </td>
                        <td>
                            <el-button type="success" class="text-white" @click="openWhastappForm(box)">
                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            </el-button>
                            <el-button type="primary" @click="seeDetail(box)">
                                Ver
                            </el-button>
                            <el-button class="margin-left:10px;" type="primary" @click="openA4(box)">
                                A4
                            </el-button>
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

                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination @current-change="getRecords" layout="total, prev, pager, next" :total="pagination.total"
                :current-page.sync="pagination.current_page" :page-size="Number(pagination.per_page)">
            </el-pagination>
        </div>

        <cash-modal v-if="currentBox" :cash.sync="currentBox" :area_id="area_id"
            :showDetail.sync="showDetail"></cash-modal>
        <el-dialog append-to-body width="40%" title="Enviar reporte por whatsapp" :visible.sync="showWhatsappForm">
            <div class="p-3" v-loading="loading" element-loading-text="Enviando..">
                <label for="">Número</label>
                <el-input v-model="number" style="width:100%"></el-input>
                <div class="d-flex justify-content-end p-1">
                    <el-button @click="sendWhatsapp">Enviar</el-button>
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
            pagination: {},
            number: null,
            loading: false,
            title: "Sin registros",
            showDetail: false,
            currentBox: null,
            showWhatsappForm: false,
            message: null,
            resource: null
        };
    },
    methods: {
        openExcel(cash) {
          let {id} = cash;
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
                // column: "state",
                // value: 0

                // limit: this.limit
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
        },
        close() {
            this.$emit("update:showHistoryCash");
        }
    }
};
</script>
