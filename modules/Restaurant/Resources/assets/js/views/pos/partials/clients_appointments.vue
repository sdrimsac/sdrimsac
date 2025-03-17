<template>
    <el-dialog
        :visible="showDialog"
        :close-on-click-modal="false"
        :show-close="true"
        width="90%"
        @close="closeDialog"
        class="clients-appointments-dialog"
        append-to-body
    >
        <template #title>
            <div
                class="d-flex justify-content-between align-items-center bg-primary p-3 text-white w-100"
            >
                <h4 class="m-0 text-white">Gestión de Clientes y sus Citas</h4>
                <div>{{ formattedCurrentDate }}</div>
            </div>
        </template>

        <div class="container-fluid">
            <!-- Buscador de clientes -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-10 col-12">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Buscar cliente por nombre, teléfono o email"
                                v-model="searchTerm"
                                @keyup.enter="searchClients"
                            />
                        </div>
                        <div class="input-group-append mr-2 col-md-2 col-12">
                            <button
                                class="btn btn-primary"
                                type="button"
                                @click="searchClients"
                            >
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <button
                        class="btn btn-success"
                        @click="showFormRegisterSalon = true"
                    >
                        <i class="fas fa-plus"></i> Nueva Cita
                    </button>
                </div>
            </div>

            <!-- Lista de clientes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Clientes</h5>
                        </div>
                        <div class="card-body p-0">
                            <div v-if="loadingClients" class="text-center py-5">
                                <div
                                    class="spinner-border text-primary"
                                    role="status"
                                >
                                    <span class="sr-only">Cargando...</span>
                                </div>
                                <p class="mt-2">Buscando clientes...</p>
                            </div>
                            <div v-else-if="clients.length === 0" class="text-center py-5">
                                <p class="mb-0">No se encontraron clientes con los criterios de búsqueda.</p>
                            </div>
                            <div v-else class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Citas</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="client in clients" :key="client.id">
                                            <td>{{ client.name }}</td>
                                            <td>{{ client.telephone || 'N/A' }}</td>
                                            <td>{{ client.email || 'N/A' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="mr-2">
                                                        <span class="badge badge-primary">{{ client.scheduled_count || 0 }}</span>
                                                        <small>Prog.</small>
                                                    </div>
                                                    <div class="mr-2">
                                                        <span class="badge badge-success">{{ client.completed_count || 0 }}</span>
                                                        <small>Comp.</small>
                                                    </div>
                                                    <div class="mr-2">
                                                        <span class="badge badge-danger">{{ client.cancelled_count || 0 }}</span>
                                                        <small>Canc.</small>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-warning">{{ client.no_show_count || 0 }}</span>
                                                        <small>No asist.</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button 
                                                        class="btn btn-sm btn-info" 
                                                        @click="viewClientHistory(client)"
                                                        title="Ver historial"
                                                    >
                                                        <i class="fas fa-history"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-success" 
                                                        @click="createAppointmentForClient(client)"
                                                        title="Nueva cita"
                                                    >
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para registrar cita -->
        <salon-form-register
            :showDialog.sync="showFormRegisterSalon"
            :preselectedClient="selectedClientForAppointment"
            :appointmentId.sync="selectedAppointmentId"
            @appointment-saved="onAppointmentSaved"
        ></salon-form-register>
        <client-history-modal
        :showDialog.sync="showClientHistoryModal"
        :client="selectedClient"
        @appointment-updated="handleAppointmentUpdated"
    />
    </el-dialog>

    <!-- Modal para ver historial del cliente -->
    
</template>

<script>
import moment from "moment";
import SalonFormRegister from "./salon_form_register.vue";
import ClientHistoryModal from "./client_history_modal.vue";

export default {
    props: {
        showDialog: {
            type: Boolean,
            required: true
        }
    },
    components: {
        SalonFormRegister,
        ClientHistoryModal
    },
    data() {
        return {
            searchTerm: "",
            clients: [],
            loadingClients: false,
            selectedClient: null,
            showClientHistoryModal: false,
            showFormRegisterSalon: false,
            selectedClientForAppointment: null,
            selectedAppointmentId: null,
            monthsSpanish: {
                January: "Enero",
                February: "Febrero",
                March: "Marzo",
                April: "Abril",
                May: "Mayo",
                June: "Junio",
                July: "Julio",
                August: "Agosto",
                September: "Septiembre",
                October: "Octubre",
                November: "Noviembre",
                December: "Diciembre"
            },
            daysSpanish: {
                Monday: "Lunes",
                Tuesday: "Martes",
                Wednesday: "Miércoles",
                Thursday: "Jueves",
                Friday: "Viernes",
                Saturday: "Sábado",
                Sunday: "Domingo"
            }
        };
    },
    computed: {
        formattedCurrentDate() {
            const date = moment();
            const day = this.daysSpanish[date.format("dddd")];
            const month = this.monthsSpanish[date.format("MMMM")];
            return `${day}, ${date.format("D")} de ${month} de ${date.format("YYYY")}`;
        }
    },
    watch: {
        showDialog(val) {
            if (val) {
                this.searchClients();
            } else {
                this.resetData();
            }
        }
    },
    methods: {
        closeDialog() {
            this.$emit("update:showDialog", false);
        },
        resetData() {
            this.searchTerm = "";
            this.clients = [];
            this.selectedClient = null;
            this.selectedClientForAppointment = null;
            this.selectedAppointmentId = null;
        },
        async searchClients() {
            this.loadingClients = true;
            try {
                let url = "/caja/estilista/appointments/clients";
                if (this.searchTerm) {
                    url += `?term=${encodeURIComponent(this.searchTerm)}`;
                }

                const response = await this.$http.get(url);
                this.clients = response.data.data;
            } catch (error) {
                console.error("Error al buscar clientes:", error);
                this.$message.error("Error al buscar clientes");
            } finally {
                this.loadingClients = false;
            }
        },
        viewClientHistory(client) {
            this.selectedClient = client;
            this.showClientHistoryModal = true;
        },
        createAppointmentForClient(client) {
            this.selectedClientForAppointment = client.id;
            this.showFormRegisterSalon = true;
        },
        onAppointmentSaved() {
            // Actualizar la lista de clientes
            this.searchClients();
            
            // Emitir evento para actualizar otras vistas
            this.$emit("appointment-updated");
        },
        handleAppointmentUpdated(data) {
            // Actualizar la lista de clientes
            this.searchClients();
            
            // Emitir evento para actualizar otras vistas
            this.$emit("appointment-updated");
        }
    }
};
</script>

<style scoped>
.clients-appointments-dialog :deep(.el-dialog) {
    max-width: 1200px;
}

.badge {
    font-size: 85%;
    padding: 0.25em 0.6em;
    border-radius: 0.25rem;
}

.badge-primary {
    background-color: #007bff;
    color: white;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

.badge-secondary {
    background-color: #6c757d;
    color: white;
}
</style>
