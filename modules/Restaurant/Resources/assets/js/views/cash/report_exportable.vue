<template>
    <div>
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
                                class="fa fa-file-export"
                                style="font-size: 2rem; margin-right: 0.5rem;"
                            ></i>
                            Exportar Reporte De Ganancia Por Almacén
                        </h4>
                    </div>
                </div>

                <div class="card" style="margin: 10px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Almacén</label>
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
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                            <div class="col-md-3 d-flex align-items-end">
                                <el-button
                                    class="submit"
                                    type="success"
                                    @click.prevent="clickDownload('excel')"
                                    :loading="loading_excel"
                                    icon="el-icon-download"
                                >
                                    {{
                                        loading_excel
                                            ? "Generando reporte..."
                                            : "Exportar a Excel ganancia"
                                    }}
                                </el-button>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <el-button
                                    class="submit"
                                    type="success"
                                    @click.prevent="clickDownloadDiscount('excel')"
                                    :loading="loading_excel_discount"
                                    icon="el-icon-download"
                                >
                                    {{
                                        loading_excel_discount
                                            ? "Generando reporte con descuento..."
                                            : "Exportar a Excel ganancia con descuento"
                                    }}
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";

export default {
    data() {
        return {
            loading_excel: false,
            loading_excel_discount: false,
            warehouses: [],
            form: {
                establishment_id: 1,
                date_start: moment().format("YYYY-MM-DD"),
                date_end: moment().format("YYYY-MM-DD")
            },
            resource: "report_cash"
        };
    },
    async created() {
        await this.$http.get(`/reports/inventory/tables`).then(response => {
            this.warehouses = response.data.warehouses;
        });
    },
    methods: {
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
        getQueryParameters() {
            return queryString.stringify(this.form);
        },

        clickDownload(type) {
            if (!this.form.date_start || !this.form.date_end) {
                this.$toast.error("Debe seleccionar un rango de fechas");
                return;
            }

            this.loading_excel = true;
            this.$toast.info("Generando reporte, por favor espere...");

            this.$http
                .get(`/${this.resource}/report_document/${type}`, {
                    params: this.form
                })
                .then(response => {
                    if (response.data.success) {
                        const filename = response.data.filename;
                        const checkInterval = 3000; // 3 segundos

                        const checkFileExists = () => {
                            this.$http
                                .get(
                                    `/${this.resource}/check-report-exists/${filename}`
                                )
                                .then(res => {
                                    if (res.data.exists) {
                                        this.loading_excel = false;
                                        window.location.href = `/${this.resource}/download-report/${filename}`;
                                        this.$toast.success(
                                            "Reporte generado correctamente"
                                        );
                                    } else {
                                        setTimeout(
                                            checkFileExists,
                                            checkInterval
                                        );
                                    }
                                })
                                .catch(() => {
                                    this.loading_excel = false;
                                    this.$toast.error(
                                        "Error al verificar el reporte"
                                    );
                                });
                        };

                        setTimeout(checkFileExists, checkInterval);
                    } else {
                        this.$toast.error("Error al generar el reporte");
                        this.loading_excel = false;
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.$toast.error("Error al generar el reporte");
                    this.loading_excel = false;
                });
        },

        clickDownloadDiscount(type) {
            if (!this.form.date_start || !this.form.date_end) {
                this.$toast.error("Debe seleccionar un rango de fechas");
                return;
            }

            this.loading_excel_discount = true;
            this.$toast.info("Generando reporte de ganancia con descuento, por favor espere...");

            this.$http
                .get(`/${this.resource}/report_document_discount/${type}`, {
                    params: this.form
                })
                .then(response => {
                    if (response.data.success) {
                        const filename = response.data.filename;
                        const checkInterval = 3000; // 3 segundos

                        const checkFileExists = () => {
                            this.$http
                                .get(
                                    `/${this.resource}/check-report-exists-discount/${filename}`
                                )
                                .then(res => {
                                    if (res.data.exists) {
                                        this.loading_excel_discount = false;
                                        window.location.href = `/${this.resource}/download-report-discount/${filename}`;
                                        this.$toast.success(
                                            "Reporte generado correctamente"
                                        );
                                    } else {
                                        setTimeout(
                                            checkFileExists,
                                            checkInterval
                                        );
                                    }
                                })
                                .catch(() => {
                                    this.loading_excel_discount = false;
                                    this.$toast.error(
                                        "Error al verificar el reporte"
                                    );
                                });
                        };

                        setTimeout(checkFileExists, checkInterval);
                    } else {
                        this.$toast.error("Error al generar el reporte");
                        this.loading_excel_discount = false;
                    }
                })
                .catch(error => {
                    console.error(error);
                    this.$toast.error("Error al generar el reporte");
                    this.loading_excel_discount = false;
                });
        }
    }
};
</script>
