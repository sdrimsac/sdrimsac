<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Reporte de Series Vendidas</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Reporte de Series Vendidas</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Series Vendidas</h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Almacen</label>
                                    <el-select
                                        v-model="form.establishment_id"
                                        clearable
                                        filterable
                                    >
                                        <el-option
                                            v-for="option in warehouses"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label"
                                        >Fecha Inicio</label
                                    >
                                    <el-date-picker
                                        style="width: 100%"
                                        v-model="form.date_start"
                                        value-format="yyyy-MM-dd"
                                    >
                                    </el-date-picker>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label"
                                        >Fecha Final</label
                                    >
                                    <el-date-picker
                                        style="width: 100%"
                                        v-model="form.date_end"
                                        value-format="yyyy-MM-dd"
                                    >
                                    </el-date-picker>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Cliente</label>
                                    <el-select
                                        v-model="form.personas"
                                        clearable
                                        filterable
                                    >
                                        <el-option
                                            v-for="option in ListPersonas"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.degres_desc"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div
                                class="
                  col-lg-8 col-md-8 col-md-8 col-sm-12
                  d-flex
                  align-items-end
                "
                            >
                                <el-button
                                    class="submit"
                                    type="primary"
                                    @click.prevent="getRecordsByFilter"
                                    :loading="loading_submit"
                                    icon="el-icon-search"
                                    >Buscar</el-button
                                >
                                <template
                                    v-if="
                                        records.length > 0 ||
                                            NotasDeventas.length > 0
                                    "
                                >
                                    <el-button
                                        style="background-color: #217346;"
                                        class="submit"
                                        @click.prevent="clickDownload('excel')"
                                        ><i
                                            class="fa fa-file-excel"
                                            style="color: white;"
                                        ></i>
                                        <span style="color: white;">EXCEL</span>
                                    </el-button>
                                    <el-button
                                        class="submit"
                                        type="success"
                                        @click.prevent="openWhastappForm()"
                                        ><i class="icofont-brand-whatsapp"></i>
                                        WHATSAPP</el-button
                                    >
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <el-tabs
                            v-model="activeName"
                            type="card"
                            tab-position="top"
                        >
                            <el-tab-pane
                                label="Facturas - Boletas"
                                name="documents"
                            >
                                <div class="row">
                                    <el-pagination
                                        @current-change="getRecordsByFilter"
                                        layout="total, prev, pager, next"
                                        :total="pagination.documents.total"
                                        :current-page.sync="
                                            pagination.documents.current_page
                                        "
                                        :page-size="
                                            pagination.documents.per_page
                                        "
                                    >
                                    </el-pagination>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-hover table-striped table-condensed  table-responsive"
                                        style="width: 100%; white-space: nowrap;"
                                    >
                                        <thead>
                                            <tr slot="heading">
                                                <th>#</th>
                                                <th>Almacen</th>
                                                <th>COD. INTERNO</th>
                                                <th>PRODUCTO</th>
                                                <th>SERIE</th>
                                                <th>CLIENTE</th>
                                                <th></th>
                                                <th>NR. DOC.</th>
                                                <th>F. VENTA</th>
                                                <th>P. VENTA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(row, index) in records"
                                                :key="index"
                                            >
                                                <td>{{ index + 1 }}</td>
                                                <td>
                                                    {{
                                                        row.establish_description
                                                    }}
                                                </td>
                                                <td>
                                                    {{ row.codigoInterno }}
                                                </td>

                                                <td>
                                                    {{ row.descripcion }}
                                                </td>
                                                <td>
                                                    {{ row.series }}
                                                </td>
                                                <td>
                                                    {{ row.pers_name }}
                                                </td>
                                                <td>
                                                    <el-button
                                                        type="success"
                                                        size="mini"
                                                        @click="
                                                            openWhastappForm(
                                                                row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="icofont-brand-whatsapp"
                                                        ></i>
                                                    </el-button>
                                                    <el-button
                                                        size="mini"
                                                        type="primary"
                                                        @click="
                                                            printDocument(row)
                                                        "
                                                    >
                                                        <i
                                                            class="icofont-print"
                                                        ></i>
                                                    </el-button>
                                                </td>
                                                <td>
                                                    {{ row.docSeries }}
                                                </td>

                                                <td>
                                                    {{ row.docDate }}
                                                </td>
                                                <td class="text-center">
                                                    {{
                                                        Number(
                                                            row.itemValue
                                                        ).toFixed(2)
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div></div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane
                                label="Notas De ventas "
                                name="SalesNotes"
                            >
                                <div class="row">
                                    <el-pagination
                                        @current-change="getRecordsByFilter"
                                        layout="total, prev, pager, next"
                                        :total="pagination.saleNotes.total"
                                        :current-page.sync="
                                            pagination.saleNotes.current_page
                                        "
                                        :page-size="
                                            pagination.saleNotes.per_page
                                        "
                                    >
                                    </el-pagination>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-hover table-striped table-condensed  table-responsive"
                                        style="width: 100%; white-space: nowrap;"
                                    >
                                        <thead>
                                            <tr slot="heading">
                                                <th>#</th>
                                                <th>Almacen</th>
                                                <th>COD. INTERNO</th>
                                                <th>PRODUCTO</th>
                                                <th>SERIE</th>
                                                <th>CLIENTE</th>
                                                <th></th>
                                                <th>NR. DOC.</th>
                                                <th>F. VENTA</th>
                                                <th>P. VENTA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(row,
                                                index) in NotasDeventas"
                                                :key="index"
                                            >
                                                <td>{{ index + 1 }}</td>
                                                <td>
                                                    {{
                                                        row.establish_description
                                                    }}
                                                </td>
                                                <td>
                                                    {{ row.codigoInterno }}
                                                </td>
                                                <td>
                                                    {{ row.descripcion }}
                                                </td>
                                                <td>
                                                    {{ row.series }}
                                                </td>
                                                <td>
                                                    {{ row.pers_name }}
                                                </td>
                                                <td>
                                                    <el-button
                                                        type="success"
                                                        size="mini"
                                                        @click="
                                                            openWhastappForm(
                                                                row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="icofont-brand-whatsapp"
                                                        ></i>
                                                    </el-button>
                                                    <el-button
                                                        size="mini"
                                                        type="primary"
                                                        @click="
                                                            printDocument(row)
                                                        "
                                                    >
                                                        <i
                                                            class="icofont-print"
                                                        ></i>
                                                    </el-button>
                                                </td>
                                                <td>
                                                    {{ row.docSeries }}
                                                </td>
                                                <td>
                                                    {{ row.docDate }}
                                                </td>
                                                <td class="text-center">
                                                    {{
                                                        Number(
                                                            row.itemValue
                                                        ).toFixed(2)
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div></div>
                                </div>
                            </el-tab-pane>
                        </el-tabs>

                        <el-dialog
                            title="Enviar Reporte Por Whastapp"
                            :visible.sync="showWhatsappForm"
                            width="30%"
                            @close="showWhatsappForm = false"
                        >
                            <div class="row col-12">
                                <el-input
                                    class="mt-3"
                                    v-model="numeroWhatsapp"
                                    placeholder="ingrese numero para enviar "
                                    size="small"
                                    clearable
                                    >Numero a enviar
                                </el-input>
                            </div>
                            <span slot="footer">
                                <el-button @click="showWhatsappForm = false"
                                    >Cancel</el-button
                                >
                                <el-button
                                    :loading="loadbuttonwhats"
                                    type="primary"
                                    @click="SendReportWhasapp()"
                                    >Enviar</el-button
                                >
                            </span>
                        </el-dialog>

                        <whatsapp-modal
                            :company="company"
                            :documentId="documentId"
                            :documentTypeId="documentTypeId"
                            :documentNumber="documentNumber"
                            :sender="sender"
                            :establishment="establishment"
                            :showDialog.sync="showModalWhatsapp"
                        >
                        </whatsapp-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import queryString from "query-string";
import moment from "moment";
import WhatsappModal from "../../../../../Restaurant/Resources/assets/js/views/pos/partials/whatsapp_modal.vue";
export default {
    props: [],
    components: {
        WhatsappModal
    },
    data() {
        return {
            showModalWhatsapp: false,
            company: null,
            documentId: null,
            documentTypeId: null,
            documentNumber: null,
            sender: "sdrimsac",
            establishment: null,
            activeName: "documents",
            totalGeneral: null,
            totalGain: 0,
            warehouses: [],
            loading_submit: false,
            showDialog: false,
            showDialogClose: false,
            messageReport: null,
            resourceReport: null,
            open_cash: true,
            resource: "series",
            recordId: null,
            data_closed: moment().format("YYYY-MM-DD"),
            date_start: moment().format("YYYY-MM-DD"),
            month_start: moment().format("YYYY-MM"),
            cash: null,
            otroNombre: false,
            form: { date_start: null },
            records: [],
            categories: [],
            pagination: {
                saleNotes: {},
                documents: {}
            },
            showWhatsappForm: false,
            ListPersonas: [],
            NotasDeventas: [],
            numeroWhatsapp: "",
            loadbuttonwhats: null
        };
    },
    async created() {
        await this.$http.get(`/reports/inventory/tables`).then(response => {
            this.warehouses = response.data.warehouses;
            this.categories = response.data.categories;
        });
    },
    mounted() {
        this.getPersonas();
    },
    methods: {
        async Printer(Printer, linkpdf) {
            let paperConfig = {
                scaleContent: false
            };
            let config = qz.configs.create(Printer, paperConfig);

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
        printDocument(row) {
            let { external_id, printer, isNote } = row;
            let url;
            if (isNote) {
                url = `/sale-notes/print/${external_id}/ticket`;
            } else {
                //
                url = `/print/document/${external_id}/ticket`;
            }
            this.Printer(printer, url);
        },
        async getPersonas() {
            try {
                const response = await this.$http.get(
                    `${this.resource}/getPersonas`
                );
                const { data, status } = response;

                if (status == 200) {
                    this.ListPersonas = [
                        ...data.personas.map(s => {
                            s.degres_desc = `${s.name} - ${s.number} `;

                            return {
                                ...s
                            };
                        })
                    ];
                } else {
                    console.log(response);
                }
            } catch (error) {
                console.log(error);
            }
        },
        async getRecordsByFilter() {
            try {
                if (this.activeName === "documents") {
                    const response = await axios.post(
                        `${this.resource}/getDataSeries?page=${this.pagination.documents.current_page}`,
                        {
                            form: this.form
                        }
                    );

                    const { data, status } = response;
                    if (status == 200) {
                        this.records = data.datosSeries;
                        this.pagination.documents.total =
                            data.dataPaginated.total;
                        this.pagination.documents.current_page =
                            data.dataPaginated.current_page;
                        this.pagination.documents.per_page =
                            data.dataPaginated.per_page;
                    }
                }
                if (this.activeName === "SalesNotes") {
                    const response = await axios.post(
                        `${this.resource}/getDataSeriesSalesnotes?page=${this.pagination.saleNotes.current_page}`,
                        {
                            form: this.form
                        }
                    );

                    const { data, status } = response;
                    if (status == 200) {
                        this.NotasDeventas = data.datosSeries;
                        this.pagination.saleNotes.total =
                            data.dataPaginated.total;
                        this.pagination.saleNotes.current_page =
                            data.dataPaginated.current_page;
                        this.pagination.saleNotes.per_page =
                            data.dataPaginated.per_page;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        async clickDownload(type) {
            console.log(type);

            //

            const query = queryString.stringify({
                activeTab: this.activeName,
                ...this.form
            });
            console.log(query);

            try {
                window.open(`${this.resource}/reporteexcel?${query}`, "_blank");
            } catch (error) {
                console.log(error);
                this.$toast.error(error.response.data.error);
            }
        },
        openWhastappForm(row = null) {
            this.numeroWhatsapp = "";
            if (row) {
                this.company = row.company;
                this.documentId = row.documentId;
                this.documentTypeId = row.documentTypeId;
                this.documentNumber = row.documentNumber;
                this.showModalWhatsapp = true;
            } else {
                this.showWhatsappForm = true;
                this.loadbuttonwhats = false;
            }
        },

        async SendReportWhasapp() {
            console.log("enviando por whatsapp ");
            this.loadbuttonwhats = true;
            if (this.numeroWhatsapp === "") {
                this.$toast.warning(
                    "El numero para enviar no puede estar vacio "
                );
                return;
            }
            try {
                if (this.activeName === "documents") {
                    const response = await axios.post(
                        `${this.resource}/envioReportWhastap`,
                        {
                            form: this.form,
                            activeTab: this.activeName,
                            numeroWhatsapp: this.numeroWhatsapp
                        }
                    );

                    const { data, status } = response;
                    if (status == 200) {
                        this.$toast.success("Reporte enviado correctamente");
                        this.loadbuttonwhats = false;
                        this.showWhatsappForm = false;
                    }
                }
                if (this.activeName === "SalesNotes") {
                    const response = await axios.post(
                        `${this.resource}/envioReportWhastap`,
                        {
                            form: this.form,
                            activeTab: this.activeName,
                            numeroWhatsapp: this.numeroWhatsapp
                        }
                    );

                    const { data, status } = response;
                    if (status == 200) {
                        this.$toast.success("Reporte enviado correctamente");
                        this.loadbuttonwhats = false;
                        this.showWhatsappForm = false;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        }
    }
};
</script>
