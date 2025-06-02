<!-- Listado de Lotes (productos) -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h4 class="my-0 text-white d-flex align-items-center"
                                style="font-size: 1.5rem; font-weight: bold;">
                                <i class="el-icon-collection-tag mr-1"></i>
                                Listado de Lotes 
                            </h4>
                        </div>

                        <div class="data-table-visible-columns">
                            <el-dropdown :hide-on-click="false">
                                <el-tooltip content="Importa Lote de Productos en bloque" placement="top">
                                    <el-button type="primary" class="btn_buscar btn_buscar:hover"
                                        href="javascript:void(0)" @click.prevent="clickImport()">
                                        <i class="fa fa-upload"></i>
                                        Importar
                                    </el-button>
                                </el-tooltip>
                            </el-dropdown>
                        </div>
                        <div class="card-body">
                            <data-table :resource="resource" ref="dataTable">
                                <tr slot="heading" style="background-color: #073f68; color: #fff;">
                                    <th style="color: #fff;">#</th>
                                    <th style="color: #fff;">Cod. Lote</th>
                                    <th style="color: #fff;">
                                        Producto
                                    </th>
                                    <th style="color: #fff; text-align: center;">Fecha de Vencimiento</th>
                                    <th style="color: #fff; text-align: center;">
                                        Almacén
                                    </th>
                                    <th style="color: #fff; text-align: center;">
                                        Stock
                                    </th>
                                    <th style="color: #fff; text-align: center;">
                                        Estado
                                    </th>

                                    <th style="color: #fff; text-align: center;">
                                        Acciones
                                    </th>
                                </tr>

                                <tr></tr>
                                <tr slot-scope="{ index, row }">
                                    <td>
                                        {{ index }}
                                    </td>
                                    <td>
                                        {{ row.lote }}
                                    </td>
                                    <td>
                                        <strong>Cod. Int.:</strong> {{ row.item.internal_id }} <br />
                                        {{ row.item.description }}

                                    </td>
                                    <td style="text-align: center;">
                                        {{ row.date_of_due }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ row.warehouse.description }}

                                    </td>
                                    <td style="text-align: center;">
                                        {{ row.quantity }}
                                    </td>

                                    <td style="text-align: center;">
                                        <span :class="[
                                            row.status == 0 || row.status === '0'
                                                ? 'text-warning'
                                                : 'text-success',
                                            'font-weight-bold',
                                            'status-text'
                                        ]" style="font-size: 1.3em;">
                                            {{
                                                row.status == 0 || row.status === '0'
                                                    ? "Dado de baja"
                                                    : "Activo"
                                            }}
                                        </span>
                                        <br />
                                        <span :class="daysUntilDue(row.date_of_due) <
                                                0
                                                ? 'text-danger'
                                                : 'text-success'
                                            ">
                                            {{
                                                daysUntilDue(row.date_of_due) < 0 ? "Lote vencido" : `Faltan ${daysUntilDue(
                                                    row.date_of_due)} días para vencer` }} </span>
                                    </td>

                                    <td class="text-center ">

                                        <el-tooltip
                                            content="Da de baja al lote completo y registra en el Kardex la salida del mismo"
                                            placement="top">
                                            <el-button type="warning" size="mini" @click.prevent="inhabilitar(row.id)">
                                                <i class="fa fa-ban"></i>
                                                Dar de baja
                                            </el-button>
                                        </el-tooltip>


                                    </td>
                                </tr>
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>

            <lots-group-import :showDialog.sync="showImportDialog"></lots-group-import>
        </div>
    </div>
</template>

<script>
import LotsGroupImport from "./lots_group_import.vue";
import DataTable from "../../components/Datatable.vue";
export default {
    components: { DataTable, LotsGroupImport },
    data() {
        return {
            resource: "lotes",
            columns: {},
            showImportDialog: false
        };
    },
    methods: {
        parseDate(dateString) {
            // Asume que el formato es DD/MM/YYYY
            const [day, month, year] = dateString.split("/").map(Number);
            return new Date(year, month - 1, day); // Crear fecha válida
        },
        daysUntilDue(dateOfDue) {
            const today = new Date(); // Fecha actual
            const dueDate = this.parseDate(dateOfDue); // Parsear correctamente la fecha de vencimiento

            // Calcular la diferencia en milisegundos
            const diffTime = dueDate - today;

            // Convertir la diferencia a días
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // Si la fecha ya pasó, devolver un valor negativo
            return diffDays;
        },
        clickImport() {
            this.showImportDialog = true;
        },
        inhabilitar(id) {
            this.$confirm(
                "¿Está seguro de dar de baja este lote?",
                "Advertencia",
                {
                    confirmButtonText: "Sí, dar de baja",
                    cancelButtonText: "Cancelar",
                    type: "warning"
                }
            )
                .then(() => {
                    this.$http
                        .post(`/lotes/eliminated/${id}`)
                        .then(response => {
                            this.$eventHub.$emit("reloadData");
                            this.$message({
                                type: "success",
                                message: "Lote dado de baja correctamente"
                            });
                        })
                        .catch(error => {
                            console.log(error);
                            this.$message({
                                type: "error",
                                message: "Error al dar de baja el lote"
                            });
                        });
                })
                .catch(() => {
                    // User cancelled the action
                });
        }
    }
};
</script>
