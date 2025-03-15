<!-- Generar Reporte Contable -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb=0" v-loading="loading">
                <div class="card-header bg-primary">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-shopping-cart fa-1x"></i>
                        Generar Reporte Contable
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>
                                <i class="fa fa-calendar-alt fa-lg" style="color: green; margin-right: 5px;"></i>
                                Período
                            </label>
                            <br>
                            <el-date-picker
                                v-model="form.month"
                                type="month"
                                value-format="yyyy-MM"
                                format="MM/yyyy"
                                :clearable="false"
                                style="width: 100%;"
                            >
                            </el-date-picker>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <i class="fa fa-chart-line fa-lg" style="color: green; margin-right: 5px;" ></i>
                                Tipo de Reporte
                            </label>
                            <el-select v-model="form.type">
                                <el-option
                                    key="sale"
                                    value="sale"
                                    label="Venta"
                                ></el-option>
                                <el-option
                                    key="purchase"
                                    value="purchase"
                                    label="Compra"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <i class="fas fa-file-excel fa-lg" style="color: green; margin-right: 5px;"></i>
                                Formato de Exportación
                            </label>
                            <el-select v-model="form.export">
                                <el-option
                                    key="excel"
                                    value="excel"
                                    label="EXCEL"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3">
                            <!-- <el-button
                                type="primary"
                                :loading="loading_submit"
                                @click.prevent="clickDownload"
                            >
                                <template v-if="loading_submit">
                                    Generando...
                                </template>
                                <template v-else>
                                    Generar
                                </template>
                            </el-button> -->

                            <el-button
                                class="btn-save btn-save:hover"
                                icon="fas fa-file-alt fa-lg"
                                type="primary"
                                :loading="loading_submit"
                                @click.prevent="clickDownload"
                            > <template v-if="loading_submit">
                                    Generando...
                                </template>
                                <template v-else>
                                    Generar
                                </template>
                               
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import queryString from "query-string";

export default {
    data() {
        return {
            loading: false,
            loading_submit: false,
            title: null,
            resource: "account",
            error: {},
            form: {}
        };
    },
    async created() {
        this.initForm();
        this.title = "Generar";
    },
    methods: {
        initForm() {
            this.errors = {};
            this.form = {
                month: moment().format("YYYY-MM"),
                type: "sale",
                export: "EXCEL"
            };
        },
        clickDownload() {
            this.loading_submit = true;
            let query = queryString.stringify({
                ...this.form
            });
            window.open(`/${this.resource}/format/download?${query}`, "_blank");
            this.loading_submit = false;
        }
    }
};
</script>
