<template>
    <div>
        <el-dialog
            :visible="showDialog"
            :close-on-click-modal="false"
            :show-close="true"
            width="90%"
            @close="closeDialog"
            class="appointments-dialog"
            append-to-body
        >
            <template #title>
                <div class="d-flex justify-content-between align-items-center bg-primary p-3 text-white w-100">
                    <h4 class="m-0 text-white">Gestión de Citas</h4>
                    <div>{{ formattedCurrentDate }}</div>
                </div>
            </template>

            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Filtrar por fecha:</label>
                            <el-date-picker
                                v-model="filters.date"
                                type="date"
                                placeholder="Seleccione fecha"
                                format="dd/MM/yyyy"
                                value-format="yyyy-MM-dd"
                                @change="loadAppointments"
                                class="w-100"
                            ></el-date-picker>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Filtrar por estilista:</label>
                            <el-select
                                v-model="filters.stylist"
                                placeholder="Todos los estilistas"
                                clearable
                                @change="loadAppointments"
                                class="w-100"
                            >
                                <el-option
                                    v-for="user in stylists"
                                    :key="user.id"
                                    :label="user.name"
                                    :value="user.id"
                                ></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Filtrar por estado:</label>
                            <el-select
                                v-model="filters.status"
                                placeholder="Todos los estados"
                                clearable
                                @change="loadAppointments"
                                class="w-100"
                            >
                                <el-option label="Programada" value="scheduled"></el-option>
                                <el-option label="En progreso" value="in_progress"></el-option>
                                <el-option label="Completada" value="completed"></el-option>
                                <el-option label="Cancelada" value="cancelled"></el-option>
                                <el-option label="No asistió" value="no_show"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100" @click="loadAppointments">
                            <i class="fas fa-search mr-1"></i> Buscar
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Citas</h5>
                                    <div>
                                        <button class="btn btn-sm btn-success" @click="showFormRegisterSalon = true">
                                            <i class="fas fa-plus mr-1"></i> Nueva Cita
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div v-if="loading" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Cargando...</span>
                                    </div>
                                    <p class="mt-2">Cargando citas...</p>
                                </div>
                                <div v-else-if="appointments.length === 0" class="text-center py-5">
                                    <p class="mb-0">No hay citas para mostrar con los filtros seleccionados.</p>
                                </div>
                                <div v-else class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th>Cliente</th>
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
                                                <td>
                                                    <div>{{ appointment.client ? appointment.client.name : 'N/A' }}</div>
                                                    <small v-if="appointment.client && appointment.client.telephone">
                                                        <i class="fab fa-whatsapp text-success"></i> {{ appointment.client.telephone }}
                                                    </small>
                                                </td>
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
                                                            @click="viewAppointment(appointment)"
                                                            title="Ver detalles"
                                                        >
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button 
                                                            class="btn btn-sm btn-primary" 
                                                            @click="editAppointment(appointment)"
                                                            title="Editar"
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
                                                            @click="changeStatus(appointment, 'in_progress')"
                                                            title="Marcar como en progreso"
                                                            v-if="appointment.status === 'scheduled'"
                                                        >
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                        <el-tooltip content="Añadir producto a la cita/Terminar cita" placement="top">
                                                            <button 
                                                            class="btn btn-sm btn-info" 
                                                            title="Marcar como en progreso"
                                                            v-if="appointment.status === 'in_progress'"
                                                            @click="addProductToAppointment(appointment)"
                                                        >
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </button>
                                                        </el-tooltip>

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
                :categories="categories"
            ></salon-form-register>
        </el-dialog>
        
        <!-- Mover el modal de detalles fuera del diálogo principal -->
        <appointment-details
            :showDialog.sync="showAppointmentDetails"
            :appointment="selectedAppointment"
            @status-changed="handleStatusChanged"
        />
    </div>
</template>

<script>
import moment from "moment";
import SalonFormRegister from "./salon_form_register.vue";
import AppointmentDetails from './appointment_details.vue';

export default {
    props: {
        categories: {
            type: Array,
            default: []
        },
        showDialog: {
            type: Boolean,
            required: true
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
            stylists: [],
            filters: {
                date: moment().format('YYYY-MM-DD'),
                stylist: null,
                status: null
            },
            showAppointmentDetails: false,
            selectedAppointment: null,
            showFormRegisterSalon: false,
            selectedAppointmentId: null,
            selectedClientForAppointment: null,
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
                this.loadStylists();
                this.loadAppointments();
            }
        }
    },
    methods: {
        async addProductToAppointment(appointment) {
            console.log("en el modal de citas", appointment);
            this.$emit('addProductToAppointment', appointment);
            this.closeDialog();
        },
        async loadStylists() {
            try {
                const response = await this.$http.get('/caja/estilista/workers');
                this.stylists = response.data;
            } catch (error) {
                console.error('Error al cargar estilistas:', error);
                this.$message.error('Error al cargar estilistas');
            }
        },
        async loadAppointments() {
            this.loading = true;
            try {
                let url = '/caja/estilista/appointments/records?';
                const params = {};
                
                if (this.filters.date) {
                    params.date = this.filters.date;
                }
                
                if (this.filters.stylist) {
                    params.user_id = this.filters.stylist;
                }
                
                if (this.filters.status) {
                    params.status = this.filters.status;
                }
                
                // Construir la URL con los parámetros
                const queryParams = new URLSearchParams(params).toString();
                url += queryParams;
                
                const response = await this.$http.get(url);
                this.appointments = response.data.data;
            } catch (error) {
                console.error('Error al cargar citas:', error);
                this.$message.error('Error al cargar citas');
            } finally {
                this.loading = false;
            }
        },
        viewAppointment(appointment) {
            this.selectedAppointment = appointment;
            this.showAppointmentDetails = true;
        },
        editAppointment(appointment) {
            this.selectedAppointmentId = appointment.id;
            this.selectedClientForAppointment = appointment.client_id;
            this.showFormRegisterSalon = true;
        },
        async changeStatus(appointment, newStatus) {
            try {
                const response = await this.$http.put(`/caja/estilista/appointments/${appointment.id}/status`, {
                    status: newStatus
                });
                
                if (response.data.success) {
                    this.$message.success(response.data.message || 'Estado actualizado con éxito');
                    this.loadAppointments();
                    this.$emit('appointment-updated');
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
                'in_progress': 'En atención',
                'completed': 'Completada',
                'cancelled': 'Cancelada',
                'no_show': 'No asistió'
            };
            
            return statusMap[status] || status;
        },
        getStatusBadgeClass(status) {
            const classMap = {
                'scheduled': 'badge badge-primary',
                'in_progress': 'badge badge-info',
                'completed': 'badge badge-success',
                'cancelled': 'badge badge-danger',
                'no_show': 'badge badge-warning'
            };
            
            return classMap[status] || 'badge badge-secondary';
        },
        onAppointmentSaved() {
            this.loadAppointments();
            this.$emit('appointment-updated');
        },
        handleStatusChanged(data) {
            // Actualizar la cita en la lista
            const index = this.appointments.findIndex(a => a.id === data.appointmentId);
            if (index !== -1) {
                this.appointments[index].status = data.newStatus;
            }
            
            // Emitir evento para actualizar otras vistas
            this.$emit('appointment-updated');
        },
        createAppointment() {
            this.selectedClientForAppointment = null;
            this.selectedAppointmentId = null;
            this.showFormRegisterSalon = true;
        },
        closeDialog() {
            this.$emit('update:showDialog', false);
        }
    }
};
</script>

<style scoped>
.appointments-dialog :deep(.el-dialog) {
    max-width: 1200px;
}

.appointment-details p {
    margin-bottom: 0.5rem;
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
