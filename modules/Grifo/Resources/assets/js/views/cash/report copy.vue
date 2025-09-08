<!-- Reporte de Gananciás -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <!-- <div class="col-sm-6">
            <h6>
              <span>Reporte de ganancias</span>
            </h6>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/dashboard">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">
                <span class="text-muted">Ganancias</span>
              </li>
            </ol>
          </div> -->
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card mb-0">
                    <div
                        class="card-header bg-primary d-flex align-items-center"
                        style="padding: 15px;"
                    >
                        <h4
                            class="my-0 text-white d-flex align-items-center"
                            style="font-size: 1.5rem; font-weight: bold;"
                        >
                            <i
                                class="fa fa-chart-line"
                                style="font-size: 2rem; margin-right: 0.5rem;"
                            ></i>
                            Ganancias
                        </h4>
                    </div>
                </div>
                <div
                    class="data-table-visible-columns"
                    v-if="records.length > 0"
                >
                    <el-button
                        type="button"
                        class="btn_buscar"
                        style="margin-right: 5px;"
                        href="javascript:void(0)"
                        @click.prevent="clickCreate()"
                    >
                        <i class="fas fa-plus-circle fa-lg icon-style"></i>
                        Nuevo
                    </el-button>
                    <el-button
                        class="submit btn_buscar"
                        type="danger"
                        @click.prevent="clickDownload('pdf')"
                    >
                        <i class="fa fa-file-pdf"></i>
                        PDF
                    </el-button>
                    <el-button
                        class="submit btn_buscar"
                        type="success"
                        style="background-color: #28a745; border-color: #28a745;"
                        @click.prevent="clickDownload('excel')"
                    >
                        <i class="fa fa-file-excel"></i>
                        EXCEL
                    </el-button>
                    <el-button
                        class="submit btn_buscar"
                        type="success"
                        @click.prevent="openWhastappForm()"
                    >
                        <i class="icofont-brand-whatsapp"></i>
                        WHATSAPP
                    </el-button>
                </div>

                <div class="card" style="margin: 10px;">
                    <div class="card-body">
                        <h5 class="card-title">Filtros</h5>
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Almacén</label
                                        >
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Categoría</label
                                        >
                                        <el-select
                                            v-model="form.categoria_id"
                                            clearable
                                            filterable
                                        >
                                            <el-option
                                                v-for="option in categories"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.name"
                                            ></el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Producto</label
                                        >
                                        <el-select
                                            class="w-100"
                                            v-model="form.item_id"
                                            filterable
                                            remote
                                            popper-class="el-select-customers"
                                            clearable
                                            placeholder="Nombre o código interno"
                                            :remote-method="searchRemoteItems"
                                            :loading="loading_search_item"
                                        >
                                            <el-option
                                                v-for="option in items"
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
                                            style="width:100%;"
                                            v-model="form.date_start"
                                            value-format="yyyy-MM-dd"
                                            @change="checkDate"
                                        ></el-date-picker>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Fecha Final</label
                                        >
                                        <el-date-picker
                                            style="width:100%;"
                                            v-model="form.date_end"
                                            value-format="yyyy-MM-dd"
                                            @change="checkDate"
                                        ></el-date-picker>
                                    </div>
                                </div>

                                <div
                                    class="col-lg-8 col-md-8 col-md-8 col-sm-12 d-flex align-items-end"
                                >
                                    <el-button
                                        class="submit"
                                        type="primary"
                                        @click.prevent="getRecordsByFilter"
                                        :loading="loading_submit"
                                        icon="el-icon-search"
                                        >Buscar</el-button
                                    >
                                    <template v-if="records.length > 0">
                                        <el-button
                                            class="submit"
                                            type="danger"
                                            @click.prevent="
                                                clickDownload('pdf')
                                            "
                                        >
                                            <i class="fa fa-file-pdf"></i>
                                            PDF
                                        </el-button>
                                        <el-button
                                            class="submit"
                                            type="success"
                                            @click.prevent="
                                                clickDownload('excel')
                                            "
                                        >
                                            <i class="fa fa-file-excel"></i>
                                            EXCEL
                                        </el-button>
                                        <el-button
                                            class="submit"
                                            type="success"
                                            @click.prevent="openWhastappForm()"
                                        >
                                            <i
                                                class="icofont-brand-whatsapp"
                                            ></i>
                                            WHATSAPP
                                        </el-button>
                                        <span style="margin-left:15px;">
                                            <strong>TOTAL VENTA:</strong>
                                            {{
                                                totalGeneral.toLocaleString(
                                                    "es-PE",
                                                    {
                                                        style: "currency",
                                                        currency: "PEN"
                                                    }
                                                )
                                            }}
                                        </span>
                                        <span style="margin-left:15px;">
                                            <strong>TOTAL GANANCIA:</strong>
                                            {{
                                                totalGain.toLocaleString(
                                                    "es-PE",
                                                    {
                                                        style: "currency",
                                                        currency: "PEN"
                                                    }
                                                )
                                            }}
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo Doc.</th>
                                        <th>Número</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Total Venta</th>
                                        <th>Total Utilidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template
                                        v-for="(doc, index) in records"
                                        :key="index"
                                    >
                                        <tr>
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ doc.document_type }}</td>
                                            <td>{{ doc.document_number }}</td>
                                            <td>{{ doc.customer_name }}</td>
                                            <td>{{ doc.date }}</td>
                                            <td>
                                                {{
                                                    formatCurrency(
                                                        calculateTotalSale(
                                                            doc.items
                                                        )
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    formatCurrency(
                                                        doc.total_utility
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-info"
                                                    @click="
                                                        toggleDetails(index)
                                                    "
                                                >
                                                    <i
                                                        :class="{
                                                            'fa-chevron-down': !doc.showDetails,
                                                            'fa-chevron-up':
                                                                doc.showDetails
                                                        }"
                                                        class="fas"
                                                    ></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-if="doc.showDetails">
                                            <td colspan="8">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-bordered table-sm"
                                                    >
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    Producto
                                                                </th>
                                                                <th>
                                                                    Cantidad
                                                                </th>
                                                                <th>Unidad</th>
                                                                <th>
                                                                    P.U. Compra
                                                                </th>
                                                                <th>
                                                                    Total Compra
                                                                </th>
                                                                <th>
                                                                    P.U. Venta
                                                                </th>
                                                                <th>
                                                                    Total Venta
                                                                </th>
                                                                <th>
                                                                    Utilidad
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr
                                                                v-for="(item,
                                                                itemIndex) in doc.items"
                                                                :key="itemIndex"
                                                            >
                                                                <td>
                                                                    {{
                                                                        item.description
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        item.quantity
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        item.unit_type
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        formatCurrency(
                                                                            item.purchase_unit_price
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        formatCurrency(
                                                                            item.total_purchase
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        formatCurrency(
                                                                            item.unit_price
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        formatCurrency(
                                                                            item.total_sale
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        formatCurrency(
                                                                            item.utility
                                                                        )
                                                                    }}
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="font-weight-bold bg-light"
                                                            >
                                                                <td colspan="6">
                                                                    Totales del
                                                                    documento
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        formatCurrency(
                                                                            calculateTotalSale(
                                                                                doc.items
                                                                            )
                                                                        )
                                                                    }}
                                                                </td>
                                                                <td>
                                                                    {{
                                                                        formatCurrency(
                                                                            doc.total_utility
                                                                        )
                                                                    }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td colspan="5">TOTALES GENERALES</td>
                                        <td>
                                            {{ formatCurrency(totalGeneral) }}
                                        </td>
                                        <td>{{ formatCurrency(totalGain) }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr slot="heading">
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Cant. Und</th>
                                        <th v-if="!isService">
                                            P.C.
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Precio de compra"
                                                placement="top-end"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </th>
                                        <th v-if="!isService">
                                            Total C.
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Total precio compra"
                                                placement="top-end"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </th>
                                        <th>Total V.</th>
                                        <th v-if="!isService">Utilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(row, index) in records"
                                        :key="index"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            {{ row.description }}
                                            <template v-if="row.unique"
                                                >(x{{
                                                    Number(row.factor)
                                                }})</template
                                            >

                                            <template v-if="row.formatedPrices">
                                                <div class="col-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Cant.</th>
                                                               
                                                                <th>
                                                                    Precio Unit.
                                                                </th>
                                                                <th>Venta</th>
                                                              
                                                            </tr>
                                                        </thead>
                                                        <tr
                                                            v-for="(prices,
                                                            idx) in row.formatedPrices"
                                                            :key="idx"
                                                        >
                                                            <td>
                                                                <small>
                                                                    <template
                                                                        v-if="
                                                                            prices.unit_type_name
                                                                        "
                                                                    >
                                                                        {{
                                                                            Number(
                                                                                prices.count
                                                                            )
                                                                        }}
                                                                        (
                                                                        {{
                                                                            prices.unit_type_name
                                                                        }}
                                                                        )
                                                                    </template>
                                                                    <template
                                                                        v-else
                                                                    >
                                                                        {{
                                                                            Number(
                                                                                prices.count
                                                                            )
                                                                        }}
                                                                    </template>
                                                                </small>
                                                            </td>

                                                            <td>
                                                                <small>
                                                                    {{
                                                                        Number(
                                                                            prices.price
                                                                        ).toLocaleString(
                                                                            "es-PE",
                                                                            {
                                                                                style:
                                                                                    "currency",
                                                                                currency:
                                                                                    "PEN"
                                                                            }
                                                                        )
                                                                    }}
                                                                </small>
                                                            </td>

                                                            <td>
                                                                <small>
                                                                    {{
                                                                        Number(
                                                                            prices.price *
                                                                                prices.count
                                                                        ).toLocaleString(
                                                                            "es-PE",
                                                                            {
                                                                                style:
                                                                                    "currency",
                                                                                currency:
                                                                                    "PEN"
                                                                            }
                                                                        )
                                                                    }}
                                                                </small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </template>
                                        </td>
                                        <td>
                                            <template
                                                v-if="row.max_quantity_item"
                                                >{{ formatUnit(row) }}</template
                                            >
                                            <template v-else>
                                                {{ Number(row.count) }}
                                                <template
                                                    v-if="row.unit_item"
                                                    >{{
                                                        row.unit_item
                                                    }}</template
                                                >
                                            </template>
                                        </td>
                                        <td v-if="!isService">
                                            {{
                                                Number(
                                                    row.purchase_unit_price
                                                ).toLocaleString("es-PE", {
                                                    style: "currency",
                                                    currency: "PEN"
                                                })
                                            }}
                                        </td>
                                        <td v-if="!isService">
                                            {{
                                                Number(
                                                    row.totalPurchase
                                                ).toLocaleString("es-PE", {
                                                    style: "currency",
                                                    currency: "PEN"
                                                })
                                            }}
                                        </td>
                                        <td>
                                            {{
                                                Number(
                                                    row.total
                                                ).toLocaleString("es-PE", {
                                                    style: "currency",
                                                    currency: "PEN"
                                                })
                                            }}
                                        </td>
                                        <td v-if="!isService">
                                            {{
                                                Number(row.gain).toLocaleString(
                                                    "es-PE",
                                                    {
                                                        style: "currency",
                                                        currency: "PEN"
                                                    }
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div></div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <whatsapp-form-report
            :message.sync="messageReport"
            :resource="resourceReport"
            :showWhatsappForm.sync="showWhatsappForm"
        ></whatsapp-form-report>
    </div>
</template>

<script>
import { deletable } from "../../../../../../../resources/js/mixins/deletable";

import queryString from "query-string";
import moment from "moment";
import WhatsappFormReport from "../../../../../../../resources/js/components/WhatsappModalReports.vue";
export default {
    mixins: [deletable],
    components: { WhatsappFormReport },
    props: ["typeUser", "fromAdmin", "cajaopen"],
    data() {
        return {
            /* configuration: {}, */
            loading_search_item: false,
            totalGeneral: null,
            totalGain: 0,
            warehouses: [],
            loading_submit: false,
            showDialog: false,
            showDialogClose: false,
            messageReport: null,
            resourceReport: null,
            open_cash: true,
            resource: "report_cash",
            recordId: null,
            data_closed: moment().format("YYYY-MM-DD"),
            date_start: moment().format("YYYY-MM-DD"),
            month_start: moment().format("YYYY-MM"),
            cash: null,
            otroNombre: false,
            form: {},
            records: [],
            categories: [],
            pagination: {},
            showWhatsappForm: false,
            loading_search: false,
            timer: null,
            isService: false,
            items: []
        };
    },
    async created() {
        await this.$http.get(`/reports/inventory/tables`).then(response => {
            this.warehouses = response.data.warehouses;
            this.categories = response.data.categories;
            /* this.configuration = response.data.configuration; */
            console.log(response);
            /* console.log('Configuración recibida:', this.configuration);  */
        });
        this.initForm();
    },
    methods: {
        async searchRemoteItems(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        let parameters = `input=${input}`;
                        this.loading_search = true;
                        const response = await this.$http.get(
                            `/documents/data-table/items?${parameters}`
                        );

                        this.items = response.data;
                    } catch (e) {
                        console.log(e);
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        openWhastappForm() {
            this.messageReport = `Reporte de ganancias ${
                this.form.date_start
            } ${this.form.date_end ? this.form.date_end : ""}`;
            console.log(this.messageReport);
            this.resourceReport = `/${
                this.resource
            }/report/pdf?${this.getQueryParameters()}`;
            console.log(this.resourceReport);
            this.showWhatsappForm = true;
        },
        formatUnit(row) {
            let { max_quantity_item, unit_type, unit_item, count } = row;
            let full = Math.trunc(count / max_quantity_item);
            let rest = count % max_quantity_item;

            return `${full} ${unit_item} ${rest} ${unit_type}`;
        },
        checkDate() {
            if (this.form.date_end) {
                let fail =
                    moment(this.form.date_start) > moment(this.form.date_end);

                if (fail) {
                    this.form.date_end = null;
                    this.$toast.error(
                        "La fecha final no puede ser menor a la fecha de inicio"
                    );
                }
            }
        },
        initForm() {
            this.form = {
                warehouse_id: null,
                category_id: null,
                typeresult: "Detallado"
            };
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.form
            });
        },

        async getRecords() {
            let item = this.items.find(i => i.id == this.form.item_id);
            if (item) {
                this.isService = item.unit_type_description == "Servicio";
            }
            this.totalGain = 0;
            const response = await this.$http.get(
                `/${this.resource}/records?${this.getQueryParameters()}`
            );

            let items = response.data.items;
            this.totalGeneral = response.data.total;
            this.records = Object.keys(items).map(key => items[key]);

            this.records = this.records.sort((a, b) => b.count - a.count);
            this.records = this.records.map(r => {
                let formatedPrices = [];
                Object.entries(r.prices).forEach(rr => {
                    let [
                        price,
                        {
                            count,
                            factor,
                            unit_type_name,
                            unit_type,
                            unit_item,
                            max_quantity_item,
                            selectedAncho,
                            selectedLargo,
                            selectedGrosor
                        }
                    ] = rr;
                    let gain = 0;
                    let fot = null;
                    if (selectedAncho) {
                        fot =
                            (selectedAncho * selectedGrosor * selectedLargo) /
                            12;
                    }
                    let purchase =
                        Number(count) *
                        (factor ? Number(factor) : 1) *
                        Number(r.purchase_unit_price);
                    gain = Number(price) * Number(count) - purchase;

                    formatedPrices.push({
                        gain,
                        unit_type_name,
                        unit_item,
                        max_quantity_item,
                        factor,
                        price,
                        count,
                        unit_type,
                        fot,
                        selectedAncho,
                        selectedGrosor,
                        selectedLargo
                    });
                });
                r.formatedPrices = formatedPrices;

                let purchase = 0;

                purchase = Number(r.count) * Number(r.purchase_unit_price);
                r.totalPurchase = purchase;
                let gain = 0;

                gain = Number(r.total) - purchase;
                r.gain = gain;
                this.totalGain += gain;
                return r;
            });

            // this.pagination = response.data.meta;
            // this.pagination.per_page = parseInt(
            //     response.data.meta.per_page
            // );
            this.loading_submit = false;
            // this.initTotals()
        },
        async getRecordsByFilter() {
            if (this.form.date_end) {
                let fail =
                    moment(this.form.date_start) > moment(this.form.date_end);

                if (fail) {
                    this.$toast.error(
                        "La fecha final no puede ser menor a la fecha de inicio"
                    );
                    re;
                    turn;
                }
            }
            this.loading_submit = true;
            await this.getRecords();
            this.loading_submit = false;
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        ocultarBoton() {
            this.otroNombre = !this.otroNombre;
        },

        async clickDownload(id) {
            window.open(
                `/${this.resource}/report/${id}?${this.getQueryParameters()}`,
                "_blank"
            );
        },
        clickDownloadIncomeSummary(id) {
            window.open(
                `/${this.resource}/report/income-summary/${id}`,
                "_blank"
            );
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickCloseCash(recordId) {
            this.recordId = recordId;
            this.showDialogClose = true;
        },
        printreport(row) {
            window.open(
                `/caja/report-boxes/reports_resumen_type?date_end=${row.date_closed}&date_start=${row.date_closed}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf&cash_id=${row.id}`,
                "_blank"
            );
        },
        createRegister(instance, done) {
            instance.confirmButtonLoading = true;
            instance.confirmButtonText = "Cerrando caja...";
            //this.$http.get(`/${this.resource}/close/${this.recordId}`)
            window.open(
                `/caja/report-boxes/reports_resumen_type?date_end=${this.date_start}&date_start=${this.date_start}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf`,
                "_blank"
            );
            this.showDialogClose = false;
            // .then(response => {
            //     if(response.data.success){
            this.$eventHub.$emit("reloadData");
            //         this.open_cash = true
            //         this.$toast.success(response.data.message)
            //          window.open(`/caja/report-boxes/reports_resumen_type?date_end=${this.date_start}&date_start=${this.date_start}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf`, '_blank')
            //         //window.open(`/${this.resource}/${type}/?${query}`, '_blank')
            //     }else{
            //         console.log(response)
            //     }
            // })
            // .catch(error => {
            //     console.log(error)
            // })
            // .then(() => {
            instance.confirmButtonLoading = false;
            //       instance.confirmButtonText = 'Iniciar prueba'
            //     done()
            // })
        },
        clickOpenPos() {
            window.open("/pos");
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickDownloadGeneral() {
            window.open(`/${this.resource}/report`, "_blank");
        },
        clickDownloadProducts(id) {
            window.open(`/${this.resource}/report/products/${id}`, "_blank");
        }
    }
};
</script>
