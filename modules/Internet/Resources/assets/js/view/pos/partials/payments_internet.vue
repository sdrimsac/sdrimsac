<template>
    <el-dialog
        append-to-body
        :close-on-click-modal="true"
        :visible="showDialog"
        @open="open"
        @close="close"
        title="Pagos"
    >
        <div class="d-flex mt-2 justify-content-end">
            <el-button type="primary" size="mini" @click="print">
                <i class="fas fa-print"></i>
                Imprimir</el-button
            >
            <el-button
                type="success"
                size="mini"
                @click="showWhatsappModal = true"
            >
                <i class="fab fa-whatsapp"></i>
                Whatsapp</el-button
            >
        </div>
        <div v-if="payments.length > 0">
            <table class="w-100 table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Monto
                        </th>
                        <th>
                            Documento
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(net, idx) in payments" :key="idx">
                        <td>{{ customIndex(idx) }}</td>
                        <td>{{ net.dateDocPayment }}</td>
                        <td>{{ net.totalDocPayment }}</td>
                        <td>{{ net.nameDocPayment }}</td>
                        <td>
                            <el-button
                                @click="viewDocument(net.a4)"
                                type="secondary"
                                size="mini"
                            >
                                A4 PDF
                            </el-button>
                            <el-button
                                @click="viewDocument(net.ticket)"
                                type="secondary"
                                size="mini"
                            >
                                TICKET PDF
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <el-pagination
                @current-change="getPayments"
                layout="total, prev, pager, next"
                :total="pagination.total"
                :current-page.sync="pagination.current_page"
                :page-size="pagination.per_page"
            >
            </el-pagination>
        </div>
        <div v-else class="d-flex justify-content-center">
            <span class="m-5">SIN PAGOS MENSUALES</span>
        </div>

        <el-dialog
            :visible.sync="showWhatsappModal"
            title="Enviar por Whatsapp"
            @close="showWhatsappModal = false"
            @open="openWhatsapp"
            append-to-body
            v-loading="loading"
        >
            <div class="row m-3">
                <div class="col-8">
                    <el-input
                        v-model="number"
                        placeholder="Ingrese el número de celular"
                        size="mini"
                        clearable
                    ></el-input>
                </div>
                <div class="col-4">
                    <el-button type="primary" size="mini" @click="sendWhatsapp"
                        >Enviar</el-button
                    >
                    <el-button size="mini" @click="showWhatsappModal = false"
                        >Cerrar</el-button
                    >
                </div>
            </div>
            <div class="row m-3"></div>
        </el-dialog>
    </el-dialog>
</template>

<script>
import moment from "moment";
import queryString from "query-string";
export default {
    props: [
        "showDialog",
        "registerId",
        "person",
        "establishment",
        "configuration"
    ],
    data() {
        return {
            number: null,
            showWhatsappModal: false,
            payments: [],
            pagination: {},
            loading: false
        };
    },
    methods: {
        openWhatsapp() {
            this.number = this.person.telephone;
        },
        async sendWhatsapp() {
            let number = this.number;
            //check if number is numeric and has 9 digits
            if (number && number.length == 9 && !isNaN(number)) {
                let linkpdf = `/payments_print/${this.registerId}`;
                let file_name =
                    "Estado de cuenta_" +
                    (this.person ? this.person.name + "_" : "_") +
                    moment().format("YYYY-MM-DD") +
                    `.pdf`;
                try {
                    this.loading = true;
                    let formWhatsapp = {
                        resource: linkpdf,
                        file_name,
                        number: this.number,
                        message: "Estado_de_cuenta"
                    };
                    const response = await this.$http.post(
                        "/whatsapp/historial",
                        formWhatsapp
                    );
                } catch (e) {
                } finally {
                    this.loading = false;
                    this.showWhatsappModal = false;
                }
            } else {
                this.$toast.error("Ingrese un número válido");
            }
        },
        async print() {
            let printer =
                this.establishment.printer ?? this.establishment.printer_serve;
            if (!printer) {
                this.$toast.error("No se ha configurado una impresora");
                return;
            }
            let linkpdf = `/payments_print/${this.registerId}`;
            let paperConfig = {
                scaleContent: false
            };
            let config = qz.configs.create(printer, paperConfig);

            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
        },

        async open() {
            console.log(this.establishment);
            await this.getPayments();
        },
        async close() {
            this.$emit("update:showDialog", false);
        },
        viewDocument(url) {
            window.open(url);
        },
        getDocumentName({ document, sale_note }) {
            let doc = document ?? sale_note;
            if (sale_note) {
                doc.a4 = `/sale-notes/print/${sale_note.external_id}/a4`;
                doc.ticket = `/sale-notes/print/${sale_note.external_id}/ticket`;
            } else {
                doc.a4 = `/print/document/${document.external_id}/a4`;
                doc.ticket = `/print/document/${document.external_id}/ticket`;
            }
            return {
                a4: doc.a4,
                ticket: doc.ticket,
                nameDocPayment: `${doc.series}-${doc.number}`,
                totalDocPayment: doc.total,
                dateDocPayment: moment(doc.date_of_issue).format("DD/MM/YYYY")
            };
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page
            });
        },

        async getPayments() {
            const response = await this.$http(
                `/internet/payments/${
                    this.registerId
                }?${this.getQueryParameters()}`
            );
            let { data, meta } = response.data;

            this.pagination = meta;
            this.pagination.per_page = parseInt(meta.per_page);
            this.payments = data.map(p => ({
                ...p,
                ...this.getDocumentName(p)
            }));
        }
    }
};
</script>
