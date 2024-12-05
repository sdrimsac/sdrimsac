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
                        <el-button type="primary"
                       
                            
                        @click="editHistory()"
                            >Crear Nuevo Historia</el-button
                        >
                    </div>
                </div>
                <br />
            </div>
            <div class="form-body">
                <div class="row">
                    <table
                        class="table table-striped table-responsive col-md-12"
                    >
                        <thead>
                            <tr class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Fecha Registro</th>
                                <th class="text-white">Vehiculo</th>
                                <th class="text-white">Personal</th>
                                <th class="text-white">Motivo de Ingreso</th>
                                <th class="text-white">Trabajos Realizados</th>
                                <th class="text-white">Establecimiento</th>
                                <th class="text-white">Productos Cuenta</th>
                                <th class="text-white">Estado</th>
                                <th class="text-white">formato</th>
                                <th class="text-white">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in historial" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.created_at }}</td>
                                <td>
                                    {{ item.vehiculo_placa }} -
                                    {{ item.vehiculo_marca }}
                                </td>
                                <td>{{ item.personal_name }}</td>
                                <td>{{ item.observacion }}</td>
                                <td>{{ item.motive }}</td>
                                <td>{{ item.establishment_description }}</td>
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
                                        item.estado == 0 ? "Activo" : "Inactivo"
                                    }}
                                </td>
                                <td>
                                    <!-- Aquí asociamos el historial_id del registro con el botón -->
                                    <el-button
                                        v-for="(subItem, subIndex) in item.item"
                                        :key="subIndex"
                                        @click.prevent="clickPrintFormat(subItem.historial_id)"
                                        type="success"
                                    >
                                        PDF Vehiculo </el-button
                                    ><br />
                                    <!-- <el-button type="danger">
                                        PDF Servicio
                                    </el-button> -->
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
        </form>
        <car-vehicle
            :showDialog.sync="showDialogCarVehicle"
            :vehiculoId="selectedVehiculoId"
            :recordId="recordId"
            @actualizar="getData"
            
        ></car-vehicle>
    </el-dialog>
</template>
<script>
import CarVehicle from "./car_vehicle.vue";
export default {
    props: ["showDialog", "vehiculoId"],
    components: {
        CarVehicle
    },
    data() {
        return {
            selectedVehiculoId: null,
            showDialogCarVehicle: false,
            resource: "workshop",
            historial: [],
            record: {
                item: []
            },
            vehiculo: null,
            recordId: null
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
        /* editHistory(recordId = null) {
            this.recordId = recordId;
            this.showDialogCarVehicle = true;
        }, */
        editHistory(recordId = null) {
            const historialActivo = this.historial.find(item => item.estado === 0);
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
        clickPrintFormat(historial_id) {
            if (!historial_id) {
                console.error("historial_id no definido", historial_id);
                return;
            }
            window.open(
                `/${this.resource}/vehiculo/format-historial/${historial_id}`,
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

                    console.log("datos cargados de historial:", this.historial);
                })
                .catch(error => {
                    console.error("Servicios Detallados:", error);
                });
        },
        open() {
            console.log("Abriendo diálogo con vehiculoId:", this.vehiculoId);
            this.getData();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
