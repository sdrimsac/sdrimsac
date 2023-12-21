<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Reporte de productos por cliente</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Productos por cliente</span
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
                    <h6 class="my-0 text-white">Productos por cliente</h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12 col-lg-12 col-xl-12 ">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label"
                                        >Categoria</label
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
                                        style="width:100%;"
                                        v-model="form.date_end"
                                        value-format="yyyy-MM-dd"
                                        @change="checkDate"
                                    >
                                    </el-date-picker>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cliente</label>
                                    <el-select
                                        class="w-100"
                                        v-model="form.customer_id"
                                        filterable
                                        remote
                                        popper-class="el-select-customers"
                                        clearable
                                        placeholder="Nombre o documento"
                                        :remote-method="searchRemoteCustomers"
                                        :loading="loading_search_item"
                                    >
                                        <el-option
                                            v-for="option in customers"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.name"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div
                                class="col-lg-3 col-md-3 col-md-3 col-sm-12
                            d-flex align-items-center
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
                                <template v-if="records.length > 0">
                                    <!-- <el-button
                                        class="submit"
                                        type="danger"
                                        @click.prevent="clickDownload('pdf')"
                                        ><i class="fa fa-file-pdf"></i>
                                        PDF</el-button
                                    > -->
                                    <el-button
                                        class="submit"
                                        type="success"
                                        @click.prevent="clickDownload('excel')"
                                        ><i class="fa fa-file-excel"></i>
                                        EXCEL</el-button
                                    >
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
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr slot="heading">
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Unidades</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(row, index) in records"
                                        :key="index"
                                    >
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            {{ row.customer_name }}

                                            <template v-if="row.items">
                                                <div class="col-12">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Cant</th>
                                                                <th>Desc.</th>
                                                                <th>Doc.</th>
                                                                <th>Fecha</th>
                                                                <th>Monto</th>
                                                            </tr>
                                                        </thead>
                                                        <tr
                                                            v-for="(item,
                                                            idx) in row.items"
                                                            :key="idx"
                                                        >
                                                            <td>
                                                                <small>
                                                                    {{
                                                                        item.quantity
                                                                    }}
                                                                </small>
                                                            </td>

                                                            <td width="40%">
                                                                <small>{{
                                                                 item.description
                                                                }}</small>
                                                            </td>

                                                            <td>
                                                                <small>{{
                                                                    item.document
                                                                }}</small>
                                                            </td>

                                                            <td>
                                                                <small>{{
                                                                   item.date_of_issue
                                                                }}</small>
                                                            </td>
                                                            <td>
                                                                <small>
                                                                    {{item.total}}
                                                                </small>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </template>
                                        </td>
                                        <td>
                                            {{
                                                row.total.toLocaleString(
                                                    "es-PE",
                                                    {
                                                        style: "currency",
                                                        currency: "PEN"
                                                    }
                                                )
                                            }}
                                        </td>
                                        <td>
                                            {{ row.quantity }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <whatsapp-form-report
            :message.sync="messageReport"
            :resource="resourceReport"
            :showWhatsappForm.sync="showWhatsappForm"
        >
        </whatsapp-form-report>
    </div>
</template>

<script>
import { deletable } from "../../mixins/deletable";

import queryString from "query-string";
import moment from "moment";
import WhatsappFormReport from "../../components/WhatsappModalReports.vue";
export default {
    mixins: [deletable],
    components: { WhatsappFormReport },
    props: ["typeUser", "user", "fromAdmin", "cajaopen"],
    data() {
        return {
            customers: [],
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

            items: []
        };
    },
    async created() {
        await this.$http.get(`/reports/inventory/tables`).then(response => {
            this.warehouses = response.data.warehouses;
            this.categories = response.data.categories;
            console.log(response);
        });
    },
    methods: {
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/documents/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                    });
            }
        },
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
            this.messageReport = `Reporte de productos por cliente ${
                this.form.date_start || ""
            } ${this.form.date_end ? this.form.date_end : ""}.xlsx`;
            console.log(this.messageReport);
            this.resourceReport = `/report_product_client/report/excel?${this.getQueryParameters()}`;
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
            this.totalGain = 0;
            const response = await this.$http.get(
                `/report_product_client/records?${this.getQueryParameters()}`
            );

            if (response.status == 200) {
                let records = response.data;
                let customer_ids = new Set(records.map(r => r.customer_id));
                //agrupar por cliente
                let customers = [];
                customer_ids.forEach(id => {
                    let customer = {
                        ...records.find(r => r.customer_id == id)
                    };
                    let items = records.filter(r => r.customer_id == id);
                    delete customer.item_description;
                    delete customer.date_of_issue;
                    delete customer.series;
                    delete customer.number;
                    delete customer.total_quantity;
                    delete customer.total;
                    let quantity = 0;
                    let total = 0;
                    customer.items = items.map(i => {
                        quantity += Number(i.total_quantity);
                        total += Number(i.total);
                        return {
                            description: i.item_description,
                            date_of_issue: i.date_of_issue,
                            document: i.series + "-" + i.number,
                            quantity: i.total_quantity,
                            total: i.total
                        };
                    });
                    customer.items.sort((a, b) => {
                        return moment(a.date_of_issue) <
                            moment(b.date_of_issue)
                            ? 1
                            : -1;
                    });
                    customer.quantity = quantity;
                    customer.total = total;
                    customers.push(customer);
                });
                this.records = customers;
            }
          
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
                `/report_product_client/report/excel?${this.getQueryParameters()}`,
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
