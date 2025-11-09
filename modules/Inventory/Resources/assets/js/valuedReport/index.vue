<template>
    <div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-primary" style="padding:5px;">
                    <h5 class=" text-white">
                        <i class="fa fa-cubes text-white" style="font-size:18px;"></i>
                        Stock Valorizado de Productos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 ">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Almacén</label>
                                    <el-select v-model="form.establishment_id" clearable filterable>
                                        <el-option v-for="option in warehouses" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Categoría</label>
                                    <el-select v-model="form.categoria_id" clearable filterable>
                                        <el-option v-for="option in categories" :key="option.id" :value="option.id"
                                            :label="option.name"></el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-md-6 col-sm-12 d-flex align-items-end">
                                <el-button class="btn_guardarsmall" type="primary" @click.prevent="getRecordsByFilter"
                                    :loading="loading_submit" icon="el-icon-search">
                                    Buscar
                                </el-button>
                                
                                <template v-if="records.length > 0">
                                    <el-button class="btn_excelsmall" type="success" @click.prevent="clickDownload('excel')">
                                        <i class="fa fa-file-excel"></i>
                                        Excel
                                    </el-button>

                                    <el-button class="btn_whatsappsmall" type="success" @click.prevent="openWhastappForm()">
                                        <i class="icofont-brand-whatsapp"></i>
                                        WhatsApp
                                    </el-button>
                                    
                                </template>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-12 mt-1">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr slot="heading" style="background-color: #073f68; color: #ffffff;">
                                        <th class="text-white">#</th>
                                        <th class="text-white">Producto</th>
                                        <th class="text-white">Almacén</th>
                                        <th class="text-white">Stock actual</th>
                                        <th class="text-white">
                                            P.C.
                                            <el-tooltip class="item" effect="dark" content="Precio de compra" placement="top-end">
                                                <i class="fa fa-info-circle"></i>
                                            </el-tooltip>
                                        </th>
                                        <th class="text-white">
                                            Total C.
                                            <el-tooltip class="item" effect="dark" content="Total precio compra" placement="top-end">
                                                <i class="fa fa-info-circle"></i>
                                            </el-tooltip>
                                        </th>
                                        <th class="text-white">
                                            P.V.
                                            <el-tooltip class="item" effect="dark" content="Precio de venta" placement="top-end">
                                                <i class="fa fa-info-circle"></i>
                                            </el-tooltip>
                                        </th>
                                        <th class="text-white">Total V.</th>
                                        <th class="text-white">Utilidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in records" :key="index" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }"
>
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            {{ row.description }}
                                          
                                            
                                        </td>
                                        <td>
                                            {{ row.warehouse_description ? row.warehouse_description.replace(/^(Almac[eé]n\s*-\s*)/i, '') : '' }}
                                        </td>
                                        <td>
                                            <template v-if="row.max_quantity_item">
                                                {{ formatUnit(row) }}
                                            </template>
                                            <template v-else>
                                                {{ Number(row.stock) }}
                                                <template v-if="row.unit_type">
                                                    {{ row.unit_type }}
                                                </template>
                                            </template>
                                        </td>
                                        <td>
                                            {{
                                                Number(
                                                    row.purchase_unit_price
                                                ).toLocaleString("es-PE", {
                                                    style: "currency",
                                                    currency: "PEN"
                                                })
                                            }}
                                        </td>
                                        <td>
                                           
                                            {{
                                                Number(
                                                    row.total_purchase
                                                ).toLocaleString("es-PE", {
                                                    style: "currency",
                                                    currency: "PEN"
                                                })
                                            }}
                                           
                                        </td>
                                        <td>
                                            {{
                                                Number(
                                                    row.sale_unit_price
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
                                        <td>
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
                        </div>
                    </div>
                     <div>
                        <el-pagination @current-change="getRecords" layout="total, prev, pager, next"
                            :total="pagination.total" :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page">
                        </el-pagination>
                    </div>
                </div>
            </div>
        </div>
        <whatsapp-form-report :message.sync="messageReport" :resource="resourceReport"
            :showWhatsappForm.sync="showWhatsappForm">
        </whatsapp-form-report>
    </div>
</template>

<script>
import { deletable } from "../../../../../../resources/js/mixins/deletable";

import queryString from "query-string";
import moment from "moment";
import WhatsappFormReport from "../../../../../../resources/js/components/WhatsappModalReports.vue";
export default {
    mixins: [deletable],
    components: { WhatsappFormReport },
    props: [],
    data() {
        return {
            totalGeneral: null,
            totalGain: 0,
            warehouses: [],
            loading_submit: false,
            showDialog: false,
            showDialogClose: false,
            messageReport: null,
            resourceReport: null,
            open_cash: true,
            resource: "reports/valued",
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
            showWhatsappForm: false
        };
    },
    async created() {
        await this.$http.get(`/reports/inventory/tables`).then(response => {
            this.warehouses = response.data.warehouses;
            this.categories = response.data.categories;
        });
        await this.getRecords();
    },
    methods: {
        openWhastappForm() {

            this.messageReport = `Reporte de valorizacion del dia ${moment().format(
                "DD-MM-YYYY"
            )}.xlsx`;



            this.resourceReport = `/${this.resource
                }/excel?${this.getQueryParameters()}`;

            this.showWhatsappForm = true;
        },
        formatUnit(row) {

            let text = "";
            let { max_quantity_item, unit_type, unit_item, stock } = row;
            let full = Math.trunc(stock / max_quantity_item);
            if (full > 0) {
                text = `${full} ${unit_item || unit_type}`;
            }
            let rest = stock % max_quantity_item;

            if (rest > 0 || full == 0) {
                if (rest % 1 != 0) {
                    rest = rest.toFixed(2);
                }

                text += ` ${rest} ${unit_type}`;
            }

            return text;
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
            this.totalGain = 0;
            const response = await this.$http.get(
                `/${this.resource}/records?${this.getQueryParameters()}`
            );


            console.log(response);
            const { data, meta } = response.data;
            this.records = data;
            this.pagination = meta;
            this.loading_submit = false;

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
                `/${this.resource}/${id}?${this.getQueryParameters()}`,
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
