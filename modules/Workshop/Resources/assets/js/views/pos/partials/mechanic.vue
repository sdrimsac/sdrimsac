<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        :close-on-click-modal="false"
        @close="close"
        @open="open"
        width="90%"
        append-to-body
    >
        <form autocomplete="off" action>
            <br />
            <div class>
                <div class>
                    <div class="row">
                        <div class="col-md-3">
                            <label>cliente</label>
                            <el-input
                                v-model="form.customer"
                                placeholder="Ingrese Cliente"
                                @input="lisVehicle()"
                            >
                            </el-input>
                        </div>
                        <div class="col-md-3">
                            <label>Placa Vehiculo</label>
                            <el-input
                                v-model="form.placa"
                                placeholder="ingrese placa"
                                @input="lisVehicle()"
                            ></el-input>
                        </div>
                        <div class="col-md-6 text-end">
                            <el-button 
                                type="primary" 
                                @click="clickCreate()"
                                style="padding: 12px 24px; border-radius: 8px; font-size: 16px;"
                            >
                                Nuevo Registro
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="card-body">
                <div class="main-table-container">
                    <div class="table-scroll-container">
                        <table class="table table-striped custom-table">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-white">Acciones</th>
                                    <th class="text-white">#</th>
                                    <th class="text-white">Cliente</th>
                                    <th class="text-white">Tipo Vehiculo</th>
                                    <th class="text-white">Placa</th>
                                    <th class="text-white">Detalle</th>
                                    <!-- <th class="text-white">Marca</th>
                                    <th class="text-white">Color</th>
                                    <th class="text-white">Serie</th>
                                    <th class="text-white">Motor</th> -->
                                    <th class="text-white">Año</th>
                                    <th class="text-white">
                                        Kilometros Corridos
                                    </th>
                                    <th class="text-white">Fecha Registro</th>
                                    <th class="text-white">Productos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(vehiculo, index) in vehiculos"
                                    :key="index"
                                    :index="customIndex(index)"
                                >
                                    <td>
                                        <div class="mb-2">
                                            <el-button
                                                v-if="vehiculo.historial_id"
                                                type="success"
                                                @click="
                                                    openpayOrden(vehiculo.id)
                                                "
                                                style="width: 90%"
                                            >
                                                <i
                                                    class="fa fa-cash-register"
                                                    style="font-size: 20px;"
                                                ></i>

                                                Cobrar</el-button
                                            >
                                        </div>
                                        <div class="btn-group">
                                            <button
                                                class="btn btn-secondary dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                style="width: 120px;"
                                            >
                                                <i
                                                    class="fas fa-ellipsis-v"
                                                ></i>
                                                Opciones
                                            </button>
                                            <div
                                                class="dropdown-menu dropdown-menu-sm"
                                            >
                                                <a class="dropdown-item">
                                                    <el-button
                                                        class="w-100"
                                                        @click="
                                                            HistorialVehiculo(
                                                                vehiculo.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-list"
                                                        ></i>
                                                        Historial
                                                    </el-button>
                                                </a>
                                                <a class="dropdown-item">
                                                    <el-button
                                                        v-if="
                                                            vehiculo.historial_id
                                                        "
                                                        @click.prevent="
                                                            clickPrintFormat(
                                                                vehiculo.id
                                                            )
                                                        "
                                                        class="w-100"
                                                        type="success"
                                                    >
                                                        <i
                                                            class="far fa-file-alt"
                                                        ></i>
                                                        Format Vehiculo
                                                    </el-button>
                                                </a>
                                                <a class="dropdown-item">
                                                    <el-button
                                                        v-if="
                                                            vehiculo.historial_id
                                                        "
                                                        @click.prevent="
                                                            clickPrint(
                                                                vehiculo.id
                                                            )
                                                        "
                                                        class="w-100"
                                                        type="danger"
                                                    >
                                                        <i
                                                            class="far fa-file-alt"
                                                        ></i>
                                                        PDF
                                                    </el-button>
                                                </a>
                                                <a class="dropdown-item">
                                                    <el-button
                                                        v-if="
                                                            vehiculo.historial_id &&
                                                                vehiculo.items >
                                                                    0
                                                        "
                                                        @click.prevent="
                                                            selectEntrega(
                                                                vehiculo.historial_id
                                                            )
                                                        "
                                                        class="w-100"
                                                        type="primary"
                                                    >
                                                        <i
                                                            class="far fa-file-alt"
                                                        ></i>
                                                        TICKET ENTREGA
                                                    </el-button>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ customIndex(index) }}</td>
                                    <td>{{ vehiculo.customer_name }}</td>
                                    <td>
                                        {{ vehiculo.tipo_vehiculo_description }}
                                    </td>
                                    <td>{{ vehiculo.placa }}</td>

                                    <!-- <td>
                                        MARCA: {{ vehiculo.marca || '-' }}
                                        <br />COLOR: {{ vehiculo.color || '-' }}
                                        <br />SERIE: {{ vehiculo.serie || '-' }}
                                        <br />MOTOR: {{ vehiculo.motor || '-' }}
                                    </td> -->
                                    <td>
                                        <div>
                                            MARCA: {{ vehiculo.marca || "-" }}
                                        </div>
                                        <div>
                                            COLOR: {{ vehiculo.color || "-" }}
                                        </div>
                                        <div>
                                            SERIE: {{ vehiculo.serie || "-" }}
                                        </div>
                                        <div>
                                            MOTOR: {{ vehiculo.motor || "-" }}
                                        </div>
                                    </td>
                                    <td>{{ vehiculo.anio_fabricacion }}</td>
                                    <td>{{ vehiculo.kilometraje }}</td>
                                    <td>{{ vehiculo.created_at }}</td>
                                    <td>
                                        <el-button
                                            v-if="vehiculo.historial_id"
                                            @click="
                                                selectItem(
                                                    vehiculo.id,
                                                    vehiculo.placa,
                                                    vehiculo.historial_id
                                                )
                                            "
                                            type="primary"
                                            style="width: 60px; height: 60px; padding: 0; border-radius: 12px;"
                                        >
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Agregar Productos"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-cart-plus"
                                                    style="font-size: 24px;"
                                                ></i>
                                            </el-tooltip>
                                        </el-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <el-pagination
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"
                            @current-change="handlePageChange"
                        ></el-pagination>
                    </div>
                </div>
            </div>
            <register-history
                :showDialog.sync="showDialogRegisterHistory"
                :recordId="recordId"
                @recargar="lisVehicle"
            ></register-history>
            <historial
                :showDialog.sync="showDialogHistorial"
                :vehiculoId="selectedVehiculoId"
                @recargar="lisVehicle"
                @actualizar="refrescarDatos"
            ></historial>
            <modal-item
                :showDialog.sync="showDialogModalItem"
                :vehiculoId="selectedVehiculoId"
                :vehiculoPlaca="selectedVehiculoPlaca"
                :vehiculoHistorial="selectedHistorial"
                :nexItem="mechanicItem"
                @recargar="lisVehicle"
            ></modal-item>
            <format-pdf
                :showDialog.sync="showDialogFormatPdf"
                :vehiculoId="selectedVehiculoId"
            ></format-pdf>
        </form>
    </el-dialog>
</template>
<script>
import registerHistory from "./register_history.vue";
import historial from "./historial.vue";
import modalItem from "./modal_item.vue";
import FormatPdf from "./format_pdf.vue";
import queryString from "query-string";
export default {
    props: ["showDialog", "mechanicItem", "visible", "cash_id"],
    components: {
        registerHistory,
        historial,
        modalItem,
        FormatPdf
    },
    data() {
        return {
            pagination: {},
            showDialogFormatPdf: false,
            recordId: null,
            title: "Registro Ingreso Vehiculo",
            localMechanicItem: this.mechanicItem,
            showDialogRegisterHistory: false,
            showDialogHistorial: false,
            showDialogModalItem: false,
            resource: "workshop",
            vehiculos: [],
            loading_search: false,
            form: {
                customer_id: null,
                placa: "",
                customer: ""
            },
            customers: [],
            allFoods: [],
            nexItem: [],
            selectedVehiculoId: null,
            formatVehiculoId: null,
            selectedVehiculoPlaca: "",
            selectedHistorial: null
        };
    },
    mounted() {
        console.log(
            "Datos recibidos en mechanicItem en el modal:",
            this.mechanicItem
        );
    },
    methods: {
        refrescarDatos() {
            this.lisVehicle();
        },
        handlePageChange(page) {
            this.pagination.current_page = page;
            this.lisVehicle();
        },
        format_vehicle(id) {
            this.selectedVehiculoId = id;

            this.showDialogFormatPdf = true;
        },
        clickPrintFormat(recordId) {
            window.open(
                `/${this.resource}/vehiculo/format_vehicle/${recordId}`,
                "_blank"
            );
        },
        clickPrint(recordId) {
            window.open(
                `/${this.resource}/vehiculo/print/${recordId}/a4`,
                "_blank"
            );
        },
        selectEntrega(historial_id) {
            window.open(`/${this.resource}/ticket-entrega/${historial_id}`);
        },

        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialogRegisterHistory = true;
        },
        resetForm() {
            this.form = {
                id: null,
                customer_id: null,
                placa: "",
                tipo_vehiculo_id: null,
                serie: "",
                modelo: "",
                marca: "",
                color: "",
                motor: "",
                anio_fabricacion: "",
                kilometraje: "",
                personal_id: null,
                observacion: "",
                motive: "",
                reparacion: false,
                garantia: false,
                mantenimiento: false,
                diagnostico: false
            };
            this.errors = {};
        },
        fillForm(data) {
            this.form.id = data.id;
            this.form.customer_id = data.customer_id;
            this.form.placa = data.placa;
            this.form.tipo_vehiculo_id = data.tipo_vehiculo_id;
            this.form.serie = data.serie;
            this.form.modelo = data.modelo;
            this.form.marca = data.marca;
            this.form.color = data.color;
            this.form.motor = data.motor;
            this.form.anio_fabricacion = data.anio_fabricacion;
            this.form.kilometraje = data.kilometraje;
            this.form.personal_id = data.personal_id;
            this.form.observacion = data.observacion;
            this.form.motive = data.motive;
            this.form.reparacion = data.reparacion;
            this.form.garantia = data.garantia;
            this.form.mantenimiento = data.mantenimiento;
            this.form.diagnostico = data.diagnostico;
        },
        checkIsExistSerie() {
            let hasError = false;
            for (let ord of this.localOrden) {
                let { series_enabled } = ord.food.item;

                if (series_enabled && ord.series.length == 0) {
                    hasError = true;
                    break;
                }
            }
            return hasError;
        },

        async openpayOrden(id) {
            if (!this.cash_id) {
                this.$showSAlert(
                    "ALERTA",
                    "No tiene una caja abierta",
                    "error"
                );
                return;
            }
            this.$emit("payment", id);
            /* this.openpayOrden(id); */
        },
        selectItem(id, placa, historial_id) {
            if (historial_id == null) {
                return;
            }
            this.selectedHistorial = historial_id;
            this.selectedVehiculoId = id;
            this.selectedVehiculoPlaca = placa;
            console.log(
                "Vehiculo ID:",
                id,
                "Vehiculo Placa:",
                placa,
                "histoprial idd",
                historial_id
            );
            this.localMechanicItem = this.nexItem;
            this.showDialogModalItem = true;
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/${this.resource}/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.customers = this.all_customers;
                        }
                    });
            } else {
                this.customers = this.all_customers;
            }
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/workshop/customer/${customer_id}`)
                .then(response => {
                    this.customers = response.data.customers;
                    this.form.customer_id = customer_id;
                });
        },
        lisVehicle() {
            console.log("🔄 Mechanic.vue -> Ejecutando listVehicle()");
            this.$http
                .get(
                    `/${
                        this.resource
                    }/vehiculo/records?${this.getQueryParameters()}`
                )
                .then(response => {
                    this.vehiculos = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    /* console.log("Tipos de vehículo:", this.vehiculos); */
                })
                .catch(error => {
                    console.error(
                        "Error al obtener los tipos de vehículo:",
                        error
                    );
                });
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        getQueryParameters() {
            this.search = {
                placa: this.form.placa,
                customer: this.form.customer
            };
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            });
        },
        clickRegisterHistory() {
            this.showDialogRegisterHistory = true;
        },
        HistorialVehiculo(id) {
            this.selectedVehiculoId = id;
            console.log("Vehiculo ID Para la historia del car:", id);
            this.showDialogHistorial = true;
        },
        open() {
            this.lisVehicle();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style scoped>
.main-table-container {
    width: 100%;
    margin-bottom: 20px;
}

.table-scroll-container {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 15px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.custom-table {
    width: 100%;
    min-width: 1500px; /* Ensures table won't compress below this width */
    margin-bottom: 0;
}

.custom-table th {
    position: sticky;
    top: 0;
    color: white;
    white-space: nowrap;
    padding: 12px 15px;
    z-index: 1;
}

.custom-table td {
    padding: 10px 15px;
    white-space: nowrap;
    border-bottom: 1px solid #dee2e6;
}

/* Column widths */
.custom-table th:nth-child(1),
.custom-table td:nth-child(1) {
    min-width: 100px;
} /* Acciones */
.custom-table th:nth-child(2),
.custom-table td:nth-child(2) {
    min-width: 60px;
} /* # */
.custom-table th:nth-child(3),
.custom-table td:nth-child(3) {
    min-width: 200px;
} /* Cliente */
.custom-table th:nth-child(4),
.custom-table td:nth-child(4) {
    min-width: 150px;
} /* Vehiculo */
.custom-table th:nth-child(5),
.custom-table td:nth-child(5) {
    min-width: 120px;
} /* Placa */
.custom-table th:nth-child(6),
.custom-table td:nth-child(6) {
    min-width: 120px;
} /* Marca */
.custom-table th:nth-child(7),
.custom-table td:nth-child(7) {
    min-width: 100px;
} /* Color */
.custom-table th:nth-child(8),
.custom-table td:nth-child(8) {
    min-width: 120px;
} /* Serie */
.custom-table th:nth-child(9),
.custom-table td:nth-child(9) {
    min-width: 120px;
} /* Motor */
.custom-table th:nth-child(10),
.custom-table td:nth-child(10) {
    min-width: 80px;
} /* Año */
.custom-table th:nth-child(11),
.custom-table td:nth-child(11) {
    min-width: 150px;
} /* Kilometros */
.custom-table th:nth-child(12),
.custom-table td:nth-child(12) {
    min-width: 120px;
} /* Fecha */
.custom-table th:nth-child(13),
.custom-table td:nth-child(13) {
    min-width: 100px;
} /* Productos */
.custom-table th:nth-child(14),
.custom-table td:nth-child(14) {
    min-width: 120px;
} /* Acciones */

/* Scrollbar styling */
.table-scroll-container::-webkit-scrollbar {
    height: 8px;
    background-color: #f5f5f5;
}

.table-scroll-container::-webkit-scrollbar-thumb {
    border-radius: 4px;
    background-color: #888;
}

.table-scroll-container::-webkit-scrollbar-track {
    border-radius: 4px;
    background-color: #f5f5f5;
}

.pagination-container {
    position: sticky;
    left: 0;
    margin-top: 15px;
    padding: 10px;
    background: white;
    border-radius: 4px;
    display: flex;
    justify-content: center;
    z-index: 1;
}

@media (max-width: 768px) {
    .table-scroll-container {
        margin-bottom: 10px;
    }

    .custom-table {
        font-size: 14px;
    }

    .custom-table th,
    .custom-table td {
        padding: 8px 12px;
    }

    .pagination-container {
        overflow-x: auto;
        justify-content: flex-start;
    }

    .el-pagination {
        white-space: nowrap;
    }
}
.table-responsive {
    overflow: visible;
}
</style>
