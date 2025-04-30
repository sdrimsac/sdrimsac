<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Lotes (productos)</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lotes de productos</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h6 class="my-0  text-white">
                                Listado Lotes (productos)
                            </h6>
                        </div>

                        <div class="data-table-visible-columns">
                            <el-dropdown :hide-on-click="false">
                                <el-button
                                    type="primary"
                                    class=""
                                    href="javascript:void(0)"
                                    @click.prevent="clickImport()"
                                >
                                    <i class="fa fa-upload"></i>
                                    Importar
                                </el-button>
                                <el-button type="primary">
                                    Mostrar/Ocultar columnas<i
                                        class="el-icon-arrow-down el-icon--right"
                                    ></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item
                                        v-for="(column, index) in columns"
                                        :key="index"
                                    >
                                        <el-checkbox v-model="column.visible">{{
                                            column.title
                                        }}</el-checkbox>
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </div>
                        <div class="card-body">
                            <data-table :resource="resource">
                                <tr slot="heading">
                                    <th>#</th>
                                    <th>Lote</th>
                                    <th>
                                        Producto
                                    </th>
                                    <th>Fecha de Vencimiento</th>
                                    <th>
                                        Almacén
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Lotes Dado de baja
                                    </th>
                                    <th>
                                        Estado del Lote
                                    </th>
                                    <th>
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
                                        {{ row.item.description }} <br />

                                        {{ row.item.internal_id }}
                                    </td>
                                    <td>
                                        {{ row.date_of_due }}
                                    </td>
                                    <td>
                                        {{ row.warehouse.description }}
                                    </td>
                                    <td>
                                        {{ row.quantity }}
                                    </td>
                                    <!-- <td>
                                        {{ row.status }}
                                    </td> -->
                                    <td>
                                        <span
                                            :class="
                                                row.status == 0 || row.status === '0'
                                                    ? 'text-danger'
                                                    : 'text-success'
                                            "
                                        >
                                            {{
                                                row.status == 0 || row.status === '0'
                                                    ? "Dado de baja"
                                                    : "Activo"
                                            }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            :class="
                                                daysUntilDue(row.date_of_due) <
                                                0
                                                    ? 'text-danger'
                                                    : 'text-success'
                                            "
                                        >
                                            {{
                                                daysUntilDue(row.date_of_due) <
                                                0
                                                    ? "Lote vencido"
                                                    : `Faltan ${daysUntilDue(
                                                          row.date_of_due
                                                      )} días para vencer`
                                            }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <button
                                            class="btn p-0"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            <span
                                                class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-delay="0"
                                                title
                                                data-bs-original-title="Item Count"
                                                aria-label="Item Count"
                                                >Acciones</span
                                            >
                                        </button>
                                        <div
                                            class="dropdown-menu dropdown-menu-end bg-white"
                                            style
                                        >
                                            <a
                                                type="button"
                                                class="dropdown-item text-warning"
                                                @click.prevent="
                                                    inhabilitar(row.id)
                                                "
                                                >Inhabilitar</a
                                            >
                                        </div>
                                    </td>
                                </tr>
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>
            <lots-group-import
                :showDialog.sync="showImportDialog"
            ></lots-group-import>
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
