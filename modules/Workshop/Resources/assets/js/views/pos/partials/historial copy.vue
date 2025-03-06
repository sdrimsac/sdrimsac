<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible.sync="showDialog"
        title="Historial De Registro De Vehiculo"
        close-on-click-modal
        width="80%"
    >
        <form action="#">
            <br />
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <!-- <label for="vehiculo">Vehiculo</label>
            <el-input></el-input>-->
                    </div>
                    <div class="col-md-4">
                        <!-- <label for="vehiculo">Documento</label>
            <el-input></el-input>-->
                    </div>
                    <div class="col-md-4 text-end">
                        <el-button type="primary" size="large" @click="editHistory()"
                            >Crear Nuevo Historial</el-button
                        >
                    </div>
                </div>
                <br />
            </div>
            <div class="form-body">
                <div class="history-table-container">
                    <div class="table-scroll-wrapper">
                        <table class="table table-striped history-table">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-white">#</th>
                                    <th class="text-white">Fecha Registro</th>
                                    <th class="text-white">Vehículo</th>
                                    <th class="text-white">Mecánico</th>
                                    <th class="text-white">
                                        Motivo de Ingreso
                                    </th>
                                    <th class="text-white">
                                        Trabajos Realizados
                                    </th>
                                    <th class="text-white">Establecimiento</th>
                                    <th class="text-white">Productos Cuenta</th>
                                    <th class="text-white">Estado</th>
                                    <th class="text-white">Formato</th>
                                    <th class="text-white">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, index) in historial"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>
                                        {{ item.vehiculo_placa }} -
                                        {{ item.vehiculo_marca }}
                                    </td>
                                    <td>{{ item.personal_name }}</td>
                                    <td>{{ item.observacion }}</td>
                                    <td>{{ item.motive }}</td>
                                    <td>
                                        {{ item.establishment_description }}
                                    </td>
                                    <td class="text-center">
                                        <el-popover
                                            placement="right"
                                            width="400"
                                            trigger="click"
                                        >
                                            <!-- Tabla de items dentro del popover -->
                                            <el-table
                                                :data="item.item"
                                                style="width: 100%"
                                            >
                                                <el-table-column
                                                    width="50"
                                                    label="#"
                                                ></el-table-column>
                                                <el-table-column
                                                    label="Nombre"
                                                    width="200"
                                                >
                                                    <template v-slot="scope">{{
                                                        scope.row.description
                                                    }}</template>
                                                </el-table-column>
                                                <el-table-column
                                                    label="Cantidad"
                                                    width="100"
                                                >
                                                    <template v-slot="scope">{{
                                                        scope.row.cantidad
                                                    }}</template>
                                                </el-table-column>
                                                <el-table-column
                                                    label="Precio"
                                                    width="100"
                                                >
                                                    <template v-slot="scope">{{
                                                        scope.row.price
                                                    }}</template>
                                                </el-table-column>
                                            </el-table>
                                            <el-button slot="reference">
                                                <i class="fa fa-eye"></i>
                                            </el-button>
                                        </el-popover>
                                    </td>
                                    <td>
                                        {{
                                            item.estado == 0
                                                ? "Activo"
                                                : "Inactivo"
                                        }}
                                    </td>
                                    <td>
                                        <!-- Aquí asociamos el historial_id del registro con el botón -->
                                        <el-button
                                            @click.prevent="
                                                clickPrintFormat(item.id)
                                            "
                                            type="success"
                                        >
                                        <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Descargar formato de vehiculo"
                                                placement="top-start"
                                            >
                                            <i class="fa fa-car text-white fa-lg"></i>
                                            </el-tooltip>
                                        
                                            
                                        </el-button>
                                        <el-button
                                            @click.prevent="
                                                clickrePrint(item.id)
                                            "
                                            type="danger"
                                        >
                                         

                                         <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Descargar formato con los servicios realizados"
                                                placement="top-start"
                                            >
                                            <i class="fa fa-wrench text-white fa-lg"></i>
                                            </el-tooltip>
                                            
                                        </el-button>

                                        <el-button
                                            type="danger"
                                            size="mini"
                                            plain
                                            @click="
                                                previsualitation(
                                                    item.external_id,
                                                    item.document_type_id
                                                )
                                            "
                                        >
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Previsualización del documento emitido"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="far fa-file-pdf text-white fa-lg"
                                                ></i>
                                            </el-tooltip>
                                        </el-button>
                                    </td>
                                    <td>
                                        <el-button
                                            v-if="item.estado == 0"
                                            type="primary"
                                            @click="editHistory(item.id)"
                                            >Editar</el-button
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
        <car-vehicle
            :showDialog.sync="showDialogCarVehicle"
            :vehiculoId="selectedVehiculoId"
            :recordId="recordId"
            @actualizar="actualizarYEmitir"
        ></car-vehicle>

        <document-print-previsualitation
            :resource="resourcePdf"
            :showDialog.sync="showPrevisualitation"
        ></document-print-previsualitation>
    </el-dialog>
</template>
<script>
import CarVehicle from "./car_vehicle.vue";
const DocumentPrintPrevisualitation = () =>
    import("./document_print_previsualitation.vue");
export default {
    props: ["showDialog", "vehiculoId"],
    components: {
        CarVehicle,
        DocumentPrintPrevisualitation
    },
    data() {
        return {
            resourcePdf: null,
            selectedVehiculoId: null,
            showDialogCarVehicle: false,
            showPrevisualitation: false,
            resource: "workshop",
            historial: [],
            record: {
                item: []
            },
            vehiculo: null,
            recordId: null,
            establishment: null,
            establishment_id: null
        };
    },
    watch: {
        vehiculoId(newVal) {
            console.log("vehiculoId cambiado:", newVal);
            if (newVal) {
                this.selectedVehiculoId = newVal;
            }
        }
    },
    methods: {
        previsualitation(external_id, type) {
            let format_printer = this.establishment ? this.establishment.format_printer : null;
            console.log("🚀 ~ previsualitation ~ format_printer: ver si tienen valor", format_printer);
            let format = "";
            switch (format_printer) {
                case "1":
                    format = "a4";
                    break;
                case "2":
                    format = "a5";
                    break;
                case "3":
                    format = "ticket_50";
                    break;
                default:
                    format = "ticket";
                    break;
            }
            console.log("🚀 ~ previsualitation ~ format:", format);
            let url = null;
            if (type == "80") {
                url = `/sale-notes/print/${external_id}/${format}`;
            } else if (
                type == "03" ||
                type == "01" ||
                type == "07" ||
                type == "08"
            ) {
                url = `/print/document/${external_id}/${format}`;
            } else {
                url = `/quotations/print/${external_id}/${format}`;
            }
            this.resourcePdf = url;
            this.showPrevisualitation = true;
        },
        actualizarYEmitir() {
            this.getData();
            this.$emit("actualizar");
        },
        editHistory(recordId = null) {
            const historialActivo = this.historial.find(
                item => item.estado === 0
            );
            if (recordId === null && historialActivo) {
                this.$showSAlert(
                    "error",
                    "No puede crear una nueva historia mientras una esté activa",
                    "error"
                );
                return;
            }
            this.recordId = recordId;
            this.showDialogCarVehicle = true;
        },
        clickrePrint(historial_id) {
            let id = historial_id;
            window.open(
                `/${this.resource}/vehiculo/reprint/${historial_id}/${id}`,
                "_blank"
            );
        },

        clickPrintFormat(historial_id, sale_note_id, document_id) {
            let id = sale_note_id || document_id;
            if (!id) {
                console.error("ID no definido", id);
                return;
            }
            window.open(
                `/${this.resource}/vehiculo/format-historial/${historial_id}/${id}`,
                "_blank"
            );
        },
        selectVehiculo(item) {
            this.selectedVehiculoId = item.vehiculo_id;
            this.showDialogCarVehicle = true;
        },
        CarVehicle() {
            console.log("Valor de vehiculo:", this.vehiculo);
            const historialActivo = this.historial.find(
                item => item.estado === 0
            );

            if (historialActivo) {
                this.$showSAlert(
                    "error",
                    "No puede Abrir una nueva historia mientras uno este activo",
                    "error"
                );
                return;
            }

            if (this.selectedVehiculoId) {
                this.showDialogCarVehicle = true;
            } else {
                console.error(
                    "No se pudo abrir el diálogo, vehiculo no está definido correctamente"
                );
            }
        },
        getData() {
            this.$http

                .get(
                    `/${this.resource}/historial/records?vehiculo_id=${
                        this.vehiculoId ? this.vehiculoId : ""
                    }`
                )
                .then(response => {
                    this.historial = response.data.data;
                    if (this.historial.length > 0) {
                        this.establishment_id = this.historial[0].establishment_id;
                        this.fetchEstablishmentDetails(this.establishment_id);
                    }
                    console.log("datos cargados de historial:", this.historial);
                })
                .catch(error => {
                    console.error("Servicios Detallados:", error);
                });
        },
        fetchEstablishmentDetails(establishment_id) {
            this.$http
                .get(`/establishments/${establishment_id}`)
                .then(response => {
                    this.establishment = response.data;
                    console.log("datos cargados de establishment:", this.establishment);
                })
                .catch(error => {
                    console.error("Error al cargar los detalles del establecimiento:", error);
                });
        },
        open() {
            console.log("Abriendo diálogo con vehiculoId:", this.vehiculoId);
            this.getData();
        },
        close() {
            this.$emit("lisVehicle");
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
<style scoped>
.history-table-container {
    position: relative;
    width: 100%;
    margin: 1rem 0;
    background: white;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.table-scroll-wrapper {
    width: 100%;
    overflow-x: auto;
    padding-bottom: 5px;
}

.history-table {
    width: 100%;
    min-width: 1200px; /* Prevent table from becoming too narrow */
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.history-table th {
    position: sticky;
    top: 0;

    padding: 12px 15px;
    white-space: nowrap;
    z-index: 1;
}

.history-table td {
    padding: 10px 15px;
    white-space: nowrap;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}

/* Define column widths */
.history-table th:nth-child(1),
.history-table td:nth-child(1) {
    min-width: 50px;
} /* # */
.history-table th:nth-child(2),
.history-table td:nth-child(2) {
    min-width: 120px;
} /* Fecha */
.history-table th:nth-child(3),
.history-table td:nth-child(3) {
    min-width: 150px;
} /* Vehiculo */
.history-table th:nth-child(4),
.history-table td:nth-child(4) {
    min-width: 120px;
} /* Personal */
.history-table th:nth-child(5),
.history-table td:nth-child(5) {
    min-width: 200px;
} /* Motivo */
.history-table th:nth-child(6),
.history-table td:nth-child(6) {
    min-width: 200px;
} /* Trabajos */
.history-table th:nth-child(7),
.history-table td:nth-child(7) {
    min-width: 150px;
} /* Establecimiento */
.history-table th:nth-child(8),
.history-table td:nth-child(8) {
    min-width: 120px;
} /* Productos */
.history-table th:nth-child(9),
.history-table td:nth-child(9) {
    min-width: 100px;
} /* Estado */
.history-table th:nth-child(10),
.history-table td:nth-child(10) {
    min-width: 120px;
} /* Formato */
.history-table th:nth-child(11),
.history-table td:nth-child(11) {
    min-width: 100px;
} /* Acciones */

/* Custom scrollbar */
.table-scroll-wrapper::-webkit-scrollbar {
    height: 8px;
}

.table-scroll-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.table-scroll-wrapper::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
    background: #666;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .history-table {
        font-size: 14px;
    }

    .history-table th,
    .history-table td {
        padding: 8px 12px;
    }

    .el-button {
        padding: 8px 12px;
        font-size: 12px;
    }
}

/* Popover table styles */
.el-table {
    margin: 0;
    width: 100%;
}

.el-popover {
    max-width: 90vw;
}
</style>
