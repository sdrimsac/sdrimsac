<!-- Listado de Bancos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            Reporte de Atencion Mecanico
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fas fa-university"></i> Reporte Atencion Mecanico
                </h4>
            </div>
            <div class="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <label>Seleccione Mecanico</label>
                            <el-select
                                v-model="form.personal_id"
                                placeholder="Mecanico"
                                filterable
                                clearable
                                @change="getData"
                            >
                                <el-option
                                    v-for="item in personal"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <label>Seleccione Placa vehiculo</label>
                            <el-select
                                v-model="form.vehiculo_id"
                                placeholder="Placa"
                                filterable
                                clearable
                                @change="getData"
                            >
                                <el-option
                                    v-for="item in vehiculos"
                                    :key="item.id"
                                    :label="item.placa"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </div>
                        <!-- <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <label for="date_start">Filtro por Dia </label>
                            <el-date-picker
                                v-model="form.date_start"
                                type="date"
                                style="width: 100%;"
                                placeholder="Fecha"
                                value-format="yyyy-MM-dd"
                                @change="getData"
                            >
                            </el-date-picker>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <label for="date_start">Mes</label>
                            <el-date-picker
                                v-model="form.date_end"
                                type="month"
                                style="width: 100%;"
                                placeholder="Fecha inicial"
                                value-format="yyyy-MM-dd"
                                @change="getData"
                            >
                            </el-date-picker>
                        </div> -->
                        <div class="col-lg-3 col-md-3 col-sm-12 pb-2">
                            <el-button @click="exportExcel" 
                              type="success"
                              style="margin-top: 20px; background-color: #28a745; color: white">
                                <i class="fas fa-file-excel"></i> Exportar Excel
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">MECANICO</th>
                                <th class="text-white">CLIENTE</th>
                                <th class="text-white">TIPO VEHICULO</th>
                                <th class="text-white">PLACA</th>
                                <th class="text-white">SERIE</th>
                                <th class="text-white">MODELO</th>
                                <th class="text-white">SERVICO REALIZADO</th>
                                <th class="text-white text-end">PRECIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, index) in records"
                                :key="customIndex(index)"
                            >
                                <td>{{ customIndex(index) }}</td>
                                <td>{{ row.personal }}</td>
                                <td>{{ row.customer }}</td>
                                <td>{{ row.tipo_vehiculo }}</td>
                                <td>{{ row.placa }}</td>
                                <td>{{ row.serie }}</td>
                                <td>{{ row.modelo }}</td>
                                <!-- Aquí iteramos sobre los detalles del servicio -->
                                <td colspan="2">
                                    <table class="table">
                                        <tbody>
                                            <tr
                                                v-for="(service,
                                                sIndex) in row.historialServiceDetails"
                                                :key="sIndex"
                                            >
                                                <td>{{ service.name }}</td>
                                                <td class="text-end">
                                                    {{ service.price_unit }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <el-pagination
                        @current-change="handlePageChange"
                        layout="total, prev, pager, next"
                        :total="pagination.total"
                        :current-page="pagination.current_page"
                        :page-size="pagination.per_page"
                    >
                    </el-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { deletable } from "../../../../../../../resources/js/mixins/deletable";

export default {
    mixins: [deletable],
    props: ["typeUser"],
    components: {},
    data() {
        return {
            title: "",
            showDialog: false,
            resource: "workshop",
            recordId: null,
            records: [],
            pagination: {},
            form: {
                personal_id: "",
                vehiculo_id: "",
                date_start: "",
                date_end: ""
            },
            personal: {},
            vehiculos: {},
            searchTimeout: null
        };
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
            this.getTables();
        });
        this.getData();
        this.getTables();
    },
    methods: {
        handlePageChange(page) {
            this.getData(page);
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                (index + 1)
            );
        },
        getTables() {
            this.$http
                .get(`/${this.resource}/exportar/tables`)
                .then(response => {
                    this.personal = response.data.personal;
                    this.vehiculos = response.data.vehiculos;
                });
        },
        exportExcel() {
            try {
                const loading = this.$loading({
                    lock: true,
                    text: "Generando excel...",
                    spinner: "el-icon-loading",
                    background: "rgba(0, 0, 0, 0.7)"
                });

                let params = `?personal_id=${this.form.personal_id ||
                    ""}&vehiculo_id=${this.form.vehiculo_id ||
                    ""}&date_start=${this.form.date_start || ""}&date_end=${this
                    .form.date_end || ""}`;
                window.open(
                    `/${this.resource}/exportar/excelMechanic${params}`,
                    "_blank"
                );

                loading.close();
            } catch (error) {
                this.$message.error("Error al generar el excel");
                console.error(error);
            }
        },
        /* getData(page = 1) {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            this.searchTimeout = setTimeout(() => {
                this.$http
                    .get(`/${this.resource}/exportar/records`, {
                        params: {
                            page: page,
                            personal_id: this.form.personal_id,
                            vehiculo_id: this.form.vehiculo_id,
                            date_start: this.form.date_start,
                            date_end: this.form.date_end,
                            per_page: this.pagination.per_page || 20
                        }
                    })
                    .then(response => {
                        this.records = response.data.data;
                        this.pagination = response.data.meta;
                        this.pagination.per_page = parseInt(
                            response.data.meta.per_page
                        );
                    });
            }, 300);
        }, */

        getData(page = 1) {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            this.searchTimeout = setTimeout(() => {
                this.$http
                    .get(`/${this.resource}/exportar/records`, {
                        params: {
                            page: 1, // Fuerza la primera página
                            personal_id: this.form.personal_id,
                            vehiculo_id: this.form.vehiculo_id,
                            date_start: this.form.date_start,
                            date_end: this.form.date_end,
                            per_page: this.pagination.per_page || 20
                        }
                    })
                    .then(response => {
                        this.records = response.data.data;
                        this.pagination = response.data.meta;
                        this.pagination.current_page = 1; // Resetea la paginación
                        this.pagination.per_page = parseInt(
                            response.data.meta.per_page
                        );
                    });
            }, 300);
        }
    }
};
</script>
