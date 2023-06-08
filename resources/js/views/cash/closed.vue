<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Reporte de cierre de cajas</h6>
        </div>
        <div class="tab-content p-3">
            <form autocomplete="off" @submit.prevent="submit">
                <div class="form-body">
                    <div class="row">
                        <template>
                            <div class="col-md-3">
                                <label class="control-label w-100"
                                    >Fecha de Cierre</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    v-model="form.date_close"
                                    type="date"
                                    value-format="yyyy-MM-dd"
                                    format="dd/MM/yyyy"
                                    :clearable="false"
                                ></el-date-picker>
                            </div>
                        </template>
                        <template>
                            <div class="col-md-3">
                                <label class="control-label">Usuario</label>
                                <el-select
                                    v-model="form.user_id"
                                    clearable
                                    @change="date_start()"
                                >
                                    <el-option
                                        v-for="(data, idx) in users"
                                        :key="idx"
                                        :label="data.name"
                                        :value="data.id"
                                    ></el-option>
                                </el-select>
                            </div>
                        </template>
                        <div
                            class="col-lg-7 col-md-7 col-md-7 col-sm-12"
                            style="margin-top: 29px"
                        >
                            <el-button
                                class="submit"
                                type="success"
                                @click.prevent="getRecords"
                                :loading="loading_submit"
                                icon="el-icon-search"
                                >Buscar</el-button
                            >

                            <!-- <template v-if="records.length > 0">
                <el-button
                  class="submit"
                  type="danger"
                  icon="el-icon-tickets"
                  @click.prevent="clickDownload('pdf')"
                  >Exportar PDF</el-button
                >
              </template> -->
                        </div>
                    </div>
                    <div class="row" v-if="records.length > 0">
                        <div class="col-md-12">
                            <div class="table-responsive mt-2">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Usuario</th>
                                            <th>Referencia</th>
                                            <th>Fecha Apertura</th>
                                            <th>Dinero Apertura</th>
                                            <th>Fecha Cierre</th>
                                            <th>Dinero Cierre</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(row, index) in records"
                                            :key="index"
                                        >
                                            <td scope="row">
                                                {{ customIndex(index) }}
                                            </td>
                                            <td>{{ row.user }}</td>
                                            <td>{{ row.reference_number }}</td>
                                            <td>{{ row.date_opening }}
                                                <br>
                                                <small>
                                                    {{row.time_opening}}
                                                </small>
                                            </td>
                                            <td>{{ row.beginning_balance }}</td>
                                            <td>{{ row.date_closed }}
<br>
<small>
    {{row.time_closed}}
</small>

                                            </td>
                                            <td>{{ row.final_balance }}</td>
                                            <td>
                                                <el-button
                                                    type="success"
                                                    class="text-white"
                                                    @click="
                                                        openWhastappForm(row)
                                                    "
                                                >
                                                    <i
                                                        class="fab fa-whatsapp"
                                                        aria-hidden="true"
                                                    ></i>
                                                </el-button>
                                                <el-button
                                                    class="submit"
                                                    type="primary"
                                                    icon="el-icon-tickets"
                                                    @click="openA4(row)"
                                                    >Exportar PDF</el-button
                                                >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div>
                                    <el-pagination
                                        @current-change="getRecords"
                                        layout="total, prev, pager, next"
                                        :total="pagination.total"
                                        :current-page.sync="
                                            pagination.current_page
                                        "
                                        :page-size="pagination.per_page"
                                    >
                                    </el-pagination>
                                </div>
                            </div>
                        </div>
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
                                <el-input
                                    v-model="number"
                                    style="width:100%"
                                ></el-input>
                                <div class="d-flex justify-content-end p-1">
                                    <el-button @click="sendWhatsapp"
                                        >Enviar</el-button
                                    >
                                </div>
                            </div>
                        </el-dialog>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";
export default {
    props: ["configuration", "users"],
    components: {},
    data() {
        return {
            loading: false,
            loading_submit: false,
            titleDialog: null,
            resource: "/restaurant/worker/cash",
            form: {},
            register_group: false,
            register_category: false,
            register_subcategory: false,
            form_group: [],
            form_category: [],
            form_subcategory: [],
            pagination: {},
            search: {},
            pagination: {},
            records: [],
            totals_ingresos: 0,
            totals_egresos: 0,
            totals_efectivos: 0,
            totals_depositos: 0,
            modaltype: false,
            ruta: null,
            number: null,
            message: null,
            resourceWhatsapp: null,
            showWhatsappForm: false,
            pickerOptionsDates: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM-DD");
                    return this.form.date_start > time;
                }
            },
            pickerOptionsMonths: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM");
                    return this.form.month_start > time;
                }
            }
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        async sendWhatsapp() {
            if (!this.number || this.number.length != 9 || isNaN(this.number)) {
                return this.$toast.error("Ingrese un número válido");
            }
            this.loading = true;
            try {
                const response = await this.$http.post("/whatsapp/historial", {
                    number: this.number,
                    sender: "sdrimsac",
                    message: this.message,
                    resource: this.resourceWhatsapp,
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
        openWhastappForm(cash) {
            this.number = null;
            this.message = `Reporte de ${cash.user} ${cash.date_opening}`;
            this.resourceWhatsapp = `/restaurant/report-boxes/reports_resumen_type?cash_id=${cash.id}`;
            this.showWhatsappForm = true;
        },
        openA4(cash) {
            window.open(
                `/restaurant/report-boxes/reports_resumen_type?cash_id=${cash.id}`
            );
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                user_id: null,
                date_close: moment().format("YYYY-MM-DD"),
                type: "pdf",
                type_box: null,
                period: "month",
                date_start: null,
                date_end: moment().format("YYYY-MM-DD"),
                month_start: moment().format("YYYY-MM"),
                month_end: moment().format("YYYY-MM")
            };
        },
        create() {
            this.titleDialog = "Cajas cerradas";
        },
        async getRecordsByFilter() {
            this.loading_submit = true;
            await this.getRecords();
            this.loading_submit = false;
        },
        getRecords() {
            // window.open(`/expensesbox/reports?${this.getQueryParameters()}`, '_blank');
            this.loading_submit = true;
            this.$http
                .get(
                    `${
                        this.resource
                    }/records_closed?${this.getQueryParameters()}`
                )
                .then(response => {
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading_submit = false;
                });
        },

        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.form
            });
        },

        clickDownload(type) {
            this.modaltype = true;
            this.form.type = type;
            let form_data = this.form;
            let query = queryString.stringify({
                ...this.form
            });
            console.log(this.restaurant);
            let link = `/expensesbox/reports_pdf?${query}`;
            window.open(`${link}`, "_blank");
        },
        close() {
            this.$emit("update:showDialog_report", false);
            this.initForm();
        }
    }
};
</script>
