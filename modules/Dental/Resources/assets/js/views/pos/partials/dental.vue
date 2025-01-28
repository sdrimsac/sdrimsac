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
                        <el-input placeholder="buscar cliente"></el-input>
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
                <!-- Sección: Odontograma -->
                <odontograma
                    v-if="section === 'odontograma'"
                    :record-id="recordId"
                />
                
                <!-- Otras secciones (ejemplo) -->
                <div v-if="section === 'info'">
                    <p>Información del paciente...</p>
                </div>
                <div v-if="section === 'exploracion'">
                    <p>Exploración física...</p>
                </div>
                <div v-if="section === 'diagnostico'">
                    <p>Exploración física...</p>
                </div>
                <div v-if="section === 'evolucion'">
                    <p>Exploración física...</p>
                </div>
                <div v-if="section === 'tratamientos'">
                    <p>Exploración física...</p>
                </div>
                <div v-if="section === 'cita'">
                    <p>Exploración física...</p>
                </div>
            </div>
        </form>
    </el-dialog>
</template>
<script>
import Odontograma from "./odontograma.vue";
export default {
    props: ["showDialog", "recordId"],
    components: {
        Odontograma
    },
    data() {
        return {
            section: "",
            resource: "dental",
        };
    },
    methods: {
        changeSection(section) {
            this.section = section;
        },
        open() {
            
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
