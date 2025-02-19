<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible.sync="showDialog"
        title="Historia clinica de Paciente"
        close-on-click-modal
        width="90%"
    >
        <form action="#">
            <br />
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="vehiculo">Cliente</label>

                        <el-select
                            v-model="form.customer_id"
                            filterable
                            remote
                            class="border-left rounded-left border-info"
                            popper-class="el-select-customers"
                            dusk="customer_id"
                            placeholder="Escriba el nombre o número de documento del cliente"
                            :remote-method="searchRemoteCustomers"
                            :loading="loading_search"
                        >
                            <el-option
                                v-for="option in customers"
                                :key="option.id"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                    </div>
                </div>
                <br />
            </div>
            <div class="row">
                <div class="card col md-col-12 p-1">
                    <div
                        class="btn-group flex-wrap"
                        role="group"
                        aria-label="Basic example"
                    >
                        <el-tooltip
                            content="Información del paciente"
                            placement="top"
                        >
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="changeSection('info')"
                            >
                                <i
                                    class="fa fa-id-card-alt fa-2x"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </el-tooltip>
                        <el-tooltip
                            content="Exploración física"
                            placement="top"
                        >
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="changeSection('exploracion')"
                            >
                                <i
                                    class="fa fa-running fa-2x"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </el-tooltip>
                        <el-tooltip content="Odontograma" placement="top">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="changeSection('odontograma')"
                            >
                                <i
                                    class="fa fa-life-ring fa-2x"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </el-tooltip>
                        <el-tooltip content="Diagnóstico" placement="top">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="changeSection('diagnostico')"
                            >
                                <i
                                    class="fa fa-heartbeat fa-2x"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </el-tooltip>
                        <el-tooltip content="Evolución" placement="top">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="changeSection('evolucion')"
                            >
                                <i
                                    class="fa fa-user-md fa-2x"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </el-tooltip>
                        <el-tooltip content="Tratamientos" placement="top">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="changeSection('tratamientos')"
                            >
                                <i
                                    class="fa fa-clipboard fa-2x"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </el-tooltip>
                        <el-tooltip content="Cita" placement="top">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="changeSection('citas')"
                            >
                                <i
                                    class="fa fa-book-medical fa-2x"
                                    aria-hidden="true"
                                ></i>
                            </button>
                        </el-tooltip>
                    </div>
                </div>
            </div>
            <div class="section-content mt-4">
                <div v-if="section == 'info'">
                    <info :patient.sync="selectedPatient"></info>
                </div>
                <div v-if="section == 'exploracion'">
                    <exploracion :id.sync="selectedPatient.id"></exploracion>
                </div>
                <div v-show="section == 'odontograma'">
                    <odontograma :id.sync="selectedPatient.id"></odontograma>
                </div>
                <div v-show="section == 'diagnostico'">
                    <diagnostico :id.sync="selectedPatient.id"></diagnostico>
                </div>
                <div v-show="section == 'evolucion'">
                    <evolucion :id.sync="selectedPatient.id"></evolucion>
                </div>
                <div v-show="section == 'tratamientos'">
                    <tratamientos></tratamientos>
                </div>
                <div v-show="section == 'citas'">
                    <citas :id.sync="selectedPatient.id"></citas>
                </div>
            </div>
        </form>
    </el-dialog>
</template>
<script>
import Odontograma from "./odontograma.vue";
import Info from "./info.vue";
import Exploracion from "./exploracion.vue";
import Diagnostico from "./diagnostico.vue";
import Citas from "./citas.vue";
import Evolucion from "./evolucion.vue";
import Tratamientos from "./tratamientos.vue";

export default {
    props: ["showDialog", "recordId"],
    components: {
        Exploracion,
        Citas,
        Info,
        Odontograma,
        Diagnostico,
        Evolucion,
        Tratamientos
    },
    data() {
        return {
            section: "",
            resource: "dental",
            selectedPatient: {},
            loading_search: false,
            form: {
                customer_id: null
            },
            customers: []
        };
    },
    methods: {
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/${this.resource}/searchCustomers?${parameters}`)
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
        changeSection(section) {
            this.section = section;
        },
        open() {},
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
