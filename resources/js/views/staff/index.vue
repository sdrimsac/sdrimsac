<!-- Listado de Personal -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div
                    class="card-header bg-primary d-flex align-items-center"
                    style="padding: 12px;"
                >
                    <h3
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1rem; font-weight: bold;"
                    >
                        <i
                            class="fas fa-user-tie"
                            style="font-size: 1rem; margin-right: 1rem;"
                        ></i>
                        Listado de Personal
                    </h3>
                </div>
                <div
                    class="data-table-visible-columns"
                    style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;"
                >
                    <el-button
                        type="button"
                        class="btn_buscar"
                        style="display:inline-flex; width:auto; min-width:140px;"
                        @click.prevent="clickCreatehorarios"
                    >
                        Horarios
                    </el-button>
                    <el-button
                        type="button"
                        class="btn_buscar"
                        style="display:inline-flex; width:auto; min-width:140px;"
                        @click.prevent="clickCreateAdelanto"
                    >
                        Adelantos
                    </el-button>
                    <el-button
                        type="button"
                        class="btn_buscar"
                        style="display:inline-flex; width:auto; min-width:140px;"
                        @click.prevent="clickCreateSalary"
                    >
                        Salarios
                    </el-button>

                    <el-button
                        type="button"
                        class="btn_buscar"
                        style="display:inline-flex; width:auto; min-width:140px;"
                        @click.prevent="clickDownloadExcel"
                    >
                        Importar Asistencia
                    </el-button>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" class="bg-primary">
                            <th
                                class="text-white text-center"
                                style="width: 10px;"
                            >
                                #
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 250px;"
                            >
                                Personal
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 120px;"
                            >
                                Registro
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 120px;"
                            >
                                Rango Laborado
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 80px;"
                            >
                                H Trabajadas
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 80px;"
                            >
                                Factor Día
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 80px;"
                            >
                                HE 25%
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 80px;"
                            >
                                HE 35%
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 80px;"
                            >
                                H Faltante
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 100px;"
                            >
                                Adelantos
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 100px;"
                            >
                                Consumos
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 100px;"
                            >
                                Acciones
                            </th>
                        </tr>
                        <tr
                            slot-scope="{ index, row }"
                            :style="{
                                backgroundColor:
                                    index % 2 === 0 ? '#ffffff' : '#f0f0f0'
                            }"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>
                                {{ row.person_name }}
                                <br />
                                <strong style="text-transform: uppercase;">{{
                                    row.job_position
                                }}</strong>
                            </td>
                            <td class="text-right">
                                <span style="color: green;">Ingreso =</span>
                                {{ row.date_daily }}
                                <br />
                                <span style="color: red;">Salida =</span>
                                {{ row.date_end_daily }}
                            </td>
                            <td class="text-center">
                                <div
                                    v-if="row.pairs"
                                    style="display:inline-block; vertical-align:top; width:auto; max-width:360px;"
                                >
                                    <div
                                        v-for="(p, i) in typeof row.pairs ===
                                        'string'
                                            ? JSON.parse(row.pairs)
                                            : row.pairs"
                                        :key="i"
                                        style="display:flex; justify-content:center; align-items:center; gap:6px; padding:8px; background:#f7f9fb; border-radius:6px; border:1px solid #e3e7ea; width:auto; margin-bottom:6px;"
                                    >
                                        <div
                                            style="display:flex; align-items:center; gap:8px; white-space:nowrap;"
                                        >
                                            <strong
                                                style="font-size:0.95rem; color:#222;"
                                                >{{ p.entrance }}</strong
                                            >
                                            <span style="opacity:0.6;"
                                                ><=></span
                                            >
                                            <strong
                                                style="font-size:0.95rem; color:#222;"
                                                >{{ p.exit }}</strong
                                            >
                                            <span style="opacity:0.6;">→</span>
                                            <strong
                                                style="font-size:0.95rem; color:#222;"
                                            >
                                                {{
                                                    Math.floor(
                                                        (p.minutes || 0) / 60
                                                    )
                                                }}h
                                                {{
                                                    (
                                                        "0" +
                                                        ((p.minutes || 0) % 60)
                                                    ).slice(-2)
                                                }}m
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-else
                                    style="color:#6c757d; text-align:center; padding:8px;"
                                >
                                    -
                                </div>
                            </td>
                            <!-- <td>{{ row.date_end_daily }}</td> -->
                            <td class="text-center">
                                {{ row.horas_trabajadas }}
                            </td>
                            <td class="text-center">{{ row.factor_diario }}</td>
                            <td class="text-center">
                                {{ row.extra_time_two }}
                            </td>
                            <td class="text-center">
                                {{ row.extra_time_three }}
                            </td>
                            <td class="text-center" style="color: red;">
                                {{ row.lack_time }}
                            </td>
                            <td class="text-right">
                                {{ Number(row.advances).toFixed(2) }}
                            </td>
                            <td class="text-right">
                                {{ Number(row.consumptions).toFixed(2) }}
                            </td>
                            <td>
                                <!-- Bind per-row: when the user changes the select we call handleActionChange(row, value) -->
                                <el-select
                                    :value="row.job_position_id || null"
                                    placeholder="Seleccionar cargo"
                                    size="small"
                                    style="width: 100%;"
                                    @change="
                                        value => handleActionChange(row, value)
                                    "
                                >
                                    <el-option
                                        v-for="job_position in job_positions"
                                        :key="job_position.id"
                                        :label="job_position.name"
                                        :value="job_position.id"
                                    >
                                        <span style="float: left">{{
                                            job_position.name
                                        }}</span>
                                        <span
                                            style="float: right; color: #8492a6; font-size: 13px"
                                        >
                                            <i class="el-icon-briefcase"></i>
                                        </span>
                                    </el-option>
                                </el-select>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
        <import-excel :showDialog.sync="showDialogImportExcel"></import-excel>
        <import-dart :showDialog.sync="showDialogImportDart"></import-dart>
        <adelanto
            :showDialog.sync="showDialogAdelanto"
            :person_id.sync="person_id"
        ></adelanto>
        <salary :showDialog.sync="showDialogSalary"></salary>
        <schules
            :clickCreatehorarios.sync="showDialogHorarios"
            :staffList="records"
        ></schules>
    </div>
</template>
<script>
import DataTable from "../../components/DataTableStaff.vue";
import { deletable } from "../../mixins/deletable";
import ImportExcel from "./partials/import_excel.vue";
import ImportDart from "./partials/import_dat.vue";
import Adelanto from "./partials/adelanto.vue";
import Salary from "./partials/salary.vue";
import Schules from "./partials/schules.vue";
export default {
    props: ["typeUser"],
    mixins: [deletable],
    components: {
        DataTable,
        ImportExcel,
        Adelanto,
        Salary,
        ImportDart,
        Schules
    },
    data() {
        return {
            showDialogHorarios: false,
            showDialogImportDart: false,
            showDialogSalary: false,
            showDialogAdelanto: false,
            showDialogImportExcel: false,
            showDialog: false,
            person_id: null,
            showDialogProd: false,
            resource: "staff",
            recordId: null,
            records: [],
            staff: [],
            title: null,
            establishments: [],
            job_positions: [],
            job_position_id: null,
            document_types: [],
            ListSoldItems: [],
            persons: [],
            selectedAction: null
        };
    },

    computed: {
        totals() {
            // Sumar los totales de cada columna relevante
            const cpe = this.sellers.reduce(
                (acc, s) => acc + Number(s.documents_total || 0),
                0
            );
            const nv = this.sellers.reduce(
                (acc, s) => acc + Number(s.sale_notes_total || 0),
                0
            );
            const totalVentas = this.sellers.reduce(
                (acc, s) => acc + Number(s.total_sales || 0),
                0
            );
            const totalComision = this.sellers.reduce(
                (acc, s) => acc + Number(s.commission_earned || 0),
                0
            );
            return {
                cpe: cpe.toFixed(2),
                nv: nv.toFixed(2),
                totalVentas: totalVentas.toFixed(2),
                totalComision: totalComision.toFixed(2)
            };
        }
    },
    created() {
        this.$eventHub.$on("reloadData", () => {
            this.getData();
        });
        this.getData();
        this.getTables();
    },
    methods: {
        clickCreatehorarios() {
            this.showDialogHorarios = true;
        },

        clickCreateAdelanto() {
            this.showDialogAdelanto = true;
        },

        clickCreateSalary() {
            this.showDialogSalary = true;
        },

        clickDownloadExcel() {
            this.showDialogImportExcel = true;
        },

        clickDownloadDat() {
            this.showDialogImportDart = true;
        },

        getProd(id) {
            this.ListProdId = id;
            this.showDialogProd = true;
        },
        async getTables() {
            const response = await this.$http(`${this.resource}/tables`);
            console.log(response);
            const { establishments, job_positions } = response.data;
            this.establishments = establishments;
            this.job_positions = job_positions;
        },
        getData() {
            this.$http.get(`/${this.resource}/records`).then(response => {
                this.records = response.data.data;
            });
        },

        clickAdelanto(row = null) {
            const person_id =
                row && (row.person_id || row.person?.id || row.id)
                    ? row.person_id || row.person?.id || row.id
                    : null;
            this.person_id = person_id;
            /* console.log('ver si llega el id', this.person_id); */
            this.showDialogAdelanto = true;
        },
        async handleActionChange(row, value) {
            // Update the job_position for the daily worker summary record (row.id)
            if (!row || !row.id) {
                this.$message({
                    message: "Registro diario no disponible",
                    type: "warning"
                });
                return;
            }

            try {
                const payload = {
                    worker_daily_summary_id: row.id,
                    job_position_id: value
                };
                const response = await this.$http.post(
                    "/staff/update-job-position",
                    payload
                );
                if (response && response.data && response.data.success) {
                    this.$message({
                        message: "Cargo de trabajo actualizado",
                        type: "success"
                    });
                    this.$eventHub.$emit("reloadData");
                } else {
                    this.$message({
                        message:
                            (response &&
                                response.data &&
                                response.data.message) ||
                            "No se pudo actualizar el cargo",
                        type: "warning"
                    });
                }
            } catch (error) {
                console.error("Error updating job position", error);
                this.$message({
                    message: "Error al actualizar el cargo",
                    type: "error"
                });
            }
        }
    }
};
</script>
