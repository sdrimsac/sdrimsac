<template>
    <el-dialog
        :visible="showDialog"
        :close-on-click-modal="false"
        :show-close="true"
        width="90%"
        @close="closeDialog"
        class="client-history-dialog"
        append-to-body
    >
        <template #title>
            <div class="d-flex justify-content-between align-items-center bg-primary p-3 text-white w-100">
                <h4 class="m-0 text-white">
                    Historial de Citas: {{ client ? client.name : '' }}
                </h4>
                <div>{{ formattedCurrentDate }}</div>
            </div>
        </template>

        <div class="container-fluid">
            <!-- Información del cliente -->
            <div class="row mb-4" v-if="client">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Información del Cliente</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> {{ client.name }}</p>
                            <p v-if="client.telephone"><strong>Teléfono:</strong> {{ client.telephone }}</p>
                            <p v-if="client.email"><strong>Email:</strong> {{ client.email }}</p>
                            <div class="mt-3">
                                <button class="btn btn-success" @click="createAppointmentForClient">
                                    <i class="fas fa-plus mr-1"></i> Nueva Cita
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Resumen de Citas</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h3 class="text-primary">{{ client.scheduled_count || 0 }}</h3>
                                        <p class="mb-0">Programadas</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h3 class="text-success">{{ client.completed_count || 0 }}</h3>
                                        <p class="mb-0">Completadas</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h3 class="text-danger">{{ client.cancelled_count || 0 }}</h3>
                                        <p class="mb-0">Canceladas</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <h3 class="text-warning">{{ client.no_show_count || 0 }}</h3>
                                        <p class="mb-0">No Asistió</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de citas del cliente -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Historial de Citas</h5>
                        </div>
                        <div class="card-body p-0">
                            <div v-if="loading" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Cargando...</span>
                                </div>
                                <p class="mt-2">Cargando citas...</p>
                            </div>
                            <div v-else-if="appointments.length === 0" class="text-center py-5">
                                <p class="mb-0">Este cliente no tiene citas registradas.</p>
                            </div>
                            <div v-else class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Estilista</th>
                                            <th>Servicio</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="appointment in appointments" :key="appointment.id">
                                            <td>{{ formatDate(appointment.appointment_date) }}</td>
                                            <td>{{ appointment.start_time }} - {{ appointment.end_time }}</td>
                                            <td>{{ appointment.user ? appointment.user.name : 'N/A' }}</td>
                                            <td>{{ appointment.service ? appointment.service.description : 'N/A' }}</td>
                                            <td>
                                                <span :class="getStatusBadgeClass(appointment.status)">
                                                    {{ getStatusText(appointment.status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button 
                                                        class="btn btn-sm btn-info" 
                                                        @click="viewAppointmentDetails(appointment)"
                                                        title="Ver detalles"
                                                    >
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-primary" 
                                                        @click="editAppointment(appointment)"
                                                        title="Editar"
                                                        v-if="appointment.status === 'scheduled'"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-success" 
                                                        @click="changeStatus(appointment, 'completed')"
                                                        title="Marcar como completada"
                                                        v-if="appointment.status === 'scheduled'"
                                                    >
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-danger" 
                                                        @click="changeStatus(appointment, 'cancelled')"
                                                        title="Cancelar cita"
                                                        v-if="appointment.status === 'scheduled'"
                                                    >
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-warning" 
                                                        @click="changeStatus(appointment, 'no_show')"
                                                        title="Marcar como no asistió"
                                                        v-if="appointment.status === 'scheduled'"
                                                    >
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-info" 
                                                        @click="addProducts(appointment)"
                                                        title="Agregar productos"
                                                        v-if="appointment.status === 'in_progress'"
                                                    >
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                    <button 
                                                        class="btn btn-sm btn-primary" 
                                                        @click="changeStatus(appointment, 'in_progress')"
                                                        title="Iniciar atención"
                                                        v-if="appointment.status === 'scheduled'"
                                                    >
                                                        <i class="fas fa-play"></i>
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
            :preselectedClient="client ? client.id : null"
            :appointmentId.sync="selectedAppointmentId"
            @appointment-saved="onAppointmentSaved"
        ></salon-form-register>

        <!-- Modal para ver detalles de cita -->
        <appointment-details
            v-if="selectedAppointment"
            :showDialog.sync="showAppointmentDetails"
            :appointment="selectedAppointment"
            @status-changed="handleStatusChanged"
        ></appointment-details>
    </el-dialog>
</template>

<script>
import moment from "moment";
import SalonFormRegister from "./salon_form_register.vue";
import AppointmentDetails from "./appointment_details.vue";

export default {
    props: {
        showDialog: {
            type: Boolean,
            required: true
        },
        client: {
            type: Object,
            default: null
        }
    },
    components: {
        SalonFormRegister,
        AppointmentDetails
    },
    data() {
        return {
            loading: false,
            appointments: [],
            showAppointmentDetails: false,
            selectedAppointment: null,
            showFormRegisterSalon: false,
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
            if (val && this.client) {
                this.loadAppointments();
            }
        },
        client(val) {
            if (val && this.showDialog) {
                this.loadAppointments();
            }
        }
    },
    methods: {
        closeDialog() {
            this.$emit('update:showDialog', false);
        },
        async loadAppointments() {
            if (!this.client) return;
            
            this.loading = true;
            try {
                const response = await this.$http.get(`/caja/estilista/appointments/records?client_id=${this.client.id}`);
                this.appointments = response.data.data;
            } catch (error) {
                console.error('Error al cargar citas del cliente:', error);
                this.$message.error('Error al cargar citas del cliente');
            } finally {
                this.loading = false;
            }
        },
        createAppointmentForClient() {
            this.selectedAppointmentId = null;
            this.showFormRegisterSalon = true;
        },
        viewAppointmentDetails(appointment) {
            this.selectedAppointment = appointment;
            this.showAppointmentDetails = true;
        },
        editAppointment(appointment) {
            this.selectedAppointmentId = appointment.id;
            this.showFormRegisterSalon = true;
        },
        async changeStatus(appointment, newStatus) {
            try {
                const response = await this.$http.put(`/caja/estilista/appointments/${appointment.id}/status`, {
                    status: newStatus
                });
                
                if (response.data.success) {
                    this.$message.success(response.data.message || 'Estado actualizado con éxito');
                    
                    // Actualizar la cita en la lista local
                    const index = this.appointments.findIndex(a => a.id === appointment.id);
                    if (index !== -1) {
                        this.appointments[index].status = newStatus;
                    }
                    
                    // Emitir evento para actualizar otras vistas
                    this.$emit('appointment-updated', {
                        clientId: this.client.id,
                        appointmentId: appointment.id,
                        newStatus: newStatus
                    });
                } else {
                    this.$message.error(response.data.message || 'Error al actualizar estado');
                }
            } catch (error) {
                console.error('Error al cambiar estado:', error);
                this.$message.error('Error al actualizar estado');
            }
        },
        formatDate(date) {
            if (!date) return '';
            return moment(date).format('DD/MM/YYYY');
        },
        getStatusText(status) {
            const statusMap = {
                'scheduled': 'Programada',
                'completed': 'Completada',
                'cancelled': 'Cancelada',
                'no_show': 'No asistió',
                'in_progress': 'En atención'
            };
            
            return statusMap[status] || status;
        },
        getStatusBadgeClass(status) {
            const classMap = {
                'scheduled': 'badge badge-primary',
                'completed': 'badge badge-success',
                'cancelled': 'badge badge-danger',
                'no_show': 'badge badge-warning',
                'in_progress': 'badge badge-info'
            };
            
            return classMap[status] || 'badge badge-secondary';
        },
        onAppointmentSaved() {
            // Recargar las citas del cliente
            this.loadAppointments();
            
            // Emitir evento para actualizar otras vistas
            this.$emit('appointment-updated', {
                clientId: this.client.id
            });
        },
        handleStatusChanged(data) {
            // Actualizar la cita en la lista
            const index = this.appointments.findIndex(a => a.id === data.appointmentId);
            if (index !== -1) {
                this.appointments[index].status = data.newStatus;
            }
            
            // Emitir evento para actualizar otras vistas
            this.$emit('appointment-updated', {
                clientId: this.client.id,
                appointmentId: data.appointmentId,
                newStatus: data.newStatus
            });
        },
        addProducts(appointment) {
            // Aquí emitiremos un evento para manejar la adición de productos
            this.$emit('add-products', appointment);
        }
    }
};
</script>

<style scoped>
.client-history-dialog :deep(.el-dialog) {
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

.badge-info {
    background-color: #17a2b8;
    color: white;
}
</style> 