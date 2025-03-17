<template>
    <div>
        <div class="mb-3 d-flex justify-content-end">
            <!-- <button class="btn btn-success" @click="showAddAppointmentModal = true" :disabled="!userId">
                <i class="fas fa-plus mr-1"></i> Nueva Cita
            </button> -->
            
            <div class="d-flex">
                <div class="form-group mr-2 mb-0">
                    <el-date-picker
                        v-model="filters.date"
                        type="date"
                        placeholder="Filtrar por fecha"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                        @change="loadRecords"
                    ></el-date-picker>
                </div>
                <div class="form-group mb-0">
                    <el-select 
                        v-model="filters.status" 
                        placeholder="Filtrar por estado"
                        clearable
                        @change="loadRecords"
                    >
                        <el-option label="Programada" value="scheduled"></el-option>
                        <el-option label="Completada" value="completed"></el-option>
                        <el-option label="Cancelada" value="cancelled"></el-option>
                        <el-option label="No asistió" value="no_show"></el-option>
                    </el-select>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Cliente</th>
                        <th>Duración</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td colspan="6" class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </td>
                    </tr>
                    <tr v-else-if="records.length === 0">
                        <td colspan="6" class="text-center">No hay citas registradas</td>
                    </tr>
                    <tr v-for="record in records" :key="record.id">
                        <td>{{ formatDate(record.appointment_date) }}</td>
                        <td>{{ record.time_range }}</td>
                        <td>{{ record.client ? record.client.name : '-' }}</td>
                        <td>{{ record.duration_text }}</td>
                        <td>
                            <span 
                                :class="getStatusBadgeClass(record.status)"
                            >
                                {{ getStatusText(record.status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button 
                                    class="btn btn-info btn-sm" 
                                    @click="viewAppointment(record)"
                                    title="Ver detalles"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button 
                                    class="btn btn-primary btn-sm" 
                                    @click="editAppointment(record)"
                                    title="Editar"
                                    :disabled="record.status === 'cancelled' || record.status === 'completed'"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    class="btn btn-success btn-sm" 
                                    @click="changeStatus(record, 'completed')"
                                    title="Marcar como completada"
                                    v-if="record.status === 'scheduled'"
                                >
                                    <i class="fas fa-check"></i>
                                </button>
                                <button 
                                    class="btn btn-warning btn-sm" 
                                    @click="changeStatus(record, 'no_show')"
                                    title="Marcar como no asistió"
                                    v-if="record.status === 'scheduled'"
                                >
                                    <i class="fas fa-user-slash"></i>
                                </button>
                                <button 
                                    class="btn btn-danger btn-sm" 
                                    @click="changeStatus(record, 'cancelled')"
                                    title="Cancelar cita"
                                    v-if="record.status === 'scheduled'"
                                >
                                    <i class="fas fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Modal para agregar/editar cita -->
        <el-dialog
            :title="selectedAppointment ? 'Editar Cita' : 'Nueva Cita'"
            :visible.sync="showAddAppointmentModal"
            width="600px"
        >
            <div class="form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_id">Cliente:</label>
                            <el-select
                                v-model="form.client_id"
                                filterable
                                placeholder="Seleccione un cliente"
                                class="w-100"
                            >
                                <el-option
                                    v-for="client in clients"
                                    :key="client.id"
                                    :label="client.name"
                                    :value="client.id"
                                >
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_id">Servicio:</label>
                            <el-select
                                v-model="form.service_id"
                                filterable
                                placeholder="Seleccione un servicio"
                                class="w-100"
                                clearable
                            >
                                <el-option
                                    v-for="service in services"
                                    :key="service.id"
                                    :label="service.description"
                                    :value="service.id"
                                >
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appointment_date">Fecha:</label>
                            <el-date-picker
                                v-model="form.appointment_date"
                                type="date"
                                placeholder="Seleccione fecha"
                                format="dd/MM/yyyy"
                                value-format="yyyy-MM-dd"
                                class="w-100"
                                @change="loadAvailableSlots"
                            ></el-date-picker>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Duración (minutos):</label>
                            <el-input-number 
                                v-model="form.duration" 
                                :min="15" 
                                :max="480"
                                :step="15"
                                class="w-100"
                            ></el-input-number>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Horario disponible:</label>
                    <div v-if="loadingSlots" class="text-center py-2">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                    <div v-else-if="availableSlots.length === 0" class="alert alert-warning">
                        No hay horarios disponibles para esta fecha
                    </div>
                    <div v-else class="time-slots-container">
                        <div class="row">
                            <div 
                                v-for="(slot, index) in availableSlots" 
                                :key="index"
                                class="col-md-3 mb-2"
                            >
                                <button 
                                    class="btn btn-outline-primary btn-block time-slot"
                                    :class="{ 'active': selectedTimeSlot === index, 'disabled': !slot.available }"
                                    @click="selectTimeSlot(slot, index)"
                                    :disabled="!slot.available"
                                >
                                    {{ slot.start }} - {{ slot.end }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes">Notas:</label>
                    <textarea 
                        class="form-control" 
                        id="notes" 
                        v-model="form.notes" 
                        rows="3"
                        placeholder="Notas adicionales sobre la cita"
                    ></textarea>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showAddAppointmentModal = false">Cancelar</el-button>
                <el-button type="primary" @click="saveAppointment" :loading="saving">
                    {{ selectedAppointment ? 'Actualizar' : 'Guardar' }}
                </el-button>
            </span>
        </el-dialog>
        
        <!-- Modal para ver detalles de cita -->
        <el-dialog
            title="Detalles de la Cita"
            :visible.sync="showViewAppointmentModal"
            width="500px"
        >
            <div v-if="selectedAppointment" class="appointment-details">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cliente:</strong>
                        <p>{{ selectedAppointment.client ? selectedAppointment.client.name : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha:</strong>
                        <p>{{ formatDate(selectedAppointment.appointment_date) }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Horario:</strong>
                        <p>{{ selectedAppointment.time_range }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Duración:</strong>
                        <p>{{ selectedAppointment.duration_text }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Estado:</strong>
                        <p>
                            <span :class="getStatusBadgeClass(selectedAppointment.status)">
                                {{ getStatusText(selectedAppointment.status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Servicio:</strong>
                        <p>{{ selectedAppointment.service ? selectedAppointment.service.description : '-' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Notas:</strong>
                        <p>{{ selectedAppointment.notes || 'Sin notas' }}</p>
                    </div>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showViewAppointmentModal = false">Cerrar</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
export default {
    props: {
        userId: {
            type: [Number, String],
            required: true
        }
    },
    data() {
        return {
            loading: false,
            records: [],
            filters: {
                date: null,
                status: null
            },
            showAddAppointmentModal: false,
            showViewAppointmentModal: false,
            selectedAppointment: null,
            clients: [],
            services: [],
            form: {
                user_id: null,
                client_id: null,
                appointment_date: null,
                start_time: null,
                end_time: null,
                duration: 60,
                notes: '',
                service_id: null
            },
            saving: false,
            loadingSlots: false,
            availableSlots: [],
            selectedTimeSlot: null
        }
    },
    watch: {
        userId: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.loadRecords();
                    this.loadClients();
                    this.loadServices();
                } else {
                    this.records = [];
                }
            }
        }
    },
    methods: {
        async loadRecords() {
            if (!this.userId) return;
            
            this.loading = true;
            try {
                const params = {
                    user_id: this.userId
                };
                
                if (this.filters.date) {
                    params.date = this.filters.date;
                }
                
                if (this.filters.status) {
                    params.status = this.filters.status;
                }
                
                const response = await this.$http.get('/caja/estilista/appointments/records', { params });
                this.records = response.data.data;
            } catch (error) {
                console.error('Error al cargar citas:', error);
                this.$message.error('No se pudieron cargar las citas');
            } finally {
                this.loading = false;
            }
        },
        async loadClients() {
            try {
                const response = await this.$http.get('/caja/estilista/appointments/clients');
                this.clients = response.data;
            } catch (error) {
                console.error('Error al cargar clientes:', error);
                this.$message.error('No se pudieron cargar los clientes');
            }
        },
        async loadServices() {
            try {
                const response = await this.$http.get('/caja/estilista/appointments/services');
                this.services = response.data;
            } catch (error) {
                console.error('Error al cargar servicios:', error);
                this.$message.error('No se pudieron cargar los servicios');
            }
        },
        async loadAvailableSlots() {
            if (!this.form.appointment_date || !this.userId) return;
            
            this.loadingSlots = true;
            this.availableSlots = [];
            this.selectedTimeSlot = null;
            
            try {
                const response = await this.$http.get(`/caja/estilista/time-slots/available/${this.userId}/${this.form.appointment_date}`);
                if (response.data.success) {
                    this.availableSlots = response.data.data;
                } else {
                    this.$message.warning(response.data.message || 'No hay horarios disponibles');
                }
            } catch (error) {
                console.error('Error al cargar horarios disponibles:', error);
                this.$message.error('Error al cargar horarios disponibles');
            } finally {
                this.loadingSlots = false;
            }
        },
        viewAppointment(appointment) {
            this.selectedAppointment = appointment;
            this.showViewAppointmentModal = true;
        },
        editAppointment(appointment) {
            this.selectedAppointment = appointment;
            this.form = {
                user_id: appointment.user_id,
                client_id: appointment.client_id,
                appointment_date: appointment.appointment_date,
                start_time: this.formatTime(appointment.start_time),
                end_time: this.formatTime(appointment.end_time),
                duration: appointment.duration,
                notes: appointment.notes,
                service_id: appointment.service_id
            };
            this.showAddAppointmentModal = true;
            this.loadAvailableSlots();
        },
        async saveAppointment() {
            if (!this.form.client_id || !this.form.appointment_date || !this.form.start_time || !this.form.end_time) {
                this.$message.warning('Por favor complete todos los campos requeridos');
                return;
            }
            
            this.form.user_id = this.userId;
            
            this.saving = true;
            try {
                // Verificar disponibilidad
                const availabilityParams = {
                    user_id: this.userId,
                    date: this.form.appointment_date,
                    start_time: this.form.start_time,
                    end_time: this.form.end_time
                };
                
                if (this.selectedAppointment) {
                    availabilityParams.appointment_id = this.selectedAppointment.id;
                }
                
                const availabilityCheck = await this.$http.get('/caja/estilista/appointments/check-availability', {
                    params: availabilityParams
                });
                
                if (!availabilityCheck.data.available) {
                    this.$message.error('El horario seleccionado ya no está disponible');
                    this.saving = false;
                    return;
                }
                
                let response;
                if (this.selectedAppointment) {
                    response = await this.$http.put(`/caja/estilista/appointments/${this.selectedAppointment.id}`, this.form);
                } else {
                    response = await this.$http.post('/caja/estilista/appointments', this.form);
                }
                
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.showAddAppointmentModal = false;
                    this.loadRecords();
                } else {
                    this.$message.error(response.data.message || 'Error al guardar cita');
                }
            } catch (error) {
                console.error('Error al guardar cita:', error);
                this.$message.error('Error al guardar cita');
            } finally {
                this.saving = false;
            }
        },
        async changeStatus(appointment, status) {
            const statusTexts = {
                completed: 'completada',
                cancelled: 'cancelada',
                no_show: 'no asistió'
            };
            
            this.$confirm(`¿Está seguro de marcar esta cita como ${statusTexts[status]}?`, 'Cambiar estado', {
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar',
                type: status === 'cancelled' ? 'warning' : 'info'
            }).then(async () => {
                try {
                    const response = await this.$http.post(`/caja/estilista/appointments/change-status/${appointment.id}`, {
                        status: status
                    });
                    
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.loadRecords();
                    } else {
                        this.$message.error(response.data.message || 'Error al cambiar estado');
                    }
                } catch (error) {
                    console.error('Error al cambiar estado:', error);
                    this.$message.error('Error al cambiar estado');
                }
            }).catch(() => {
                // Cancelado
            });
        },
        selectTimeSlot(slot, index) {
            if (!slot.available) return;
            
            this.selectedTimeSlot = index;
            this.form.start_time = slot.start;
            this.form.end_time = slot.end;
        },
        getStatusText(status) {
            const statusMap = {
                scheduled: 'Programada',
                completed: 'Completada',
                cancelled: 'Cancelada',
                no_show: 'No asistió'
            };
            
            return statusMap[status] || status;
        },
        getStatusBadgeClass(status) {
            const classMap = {
                scheduled: 'badge badge-primary',
                completed: 'badge badge-success',
                cancelled: 'badge badge-danger',
                no_show: 'badge badge-warning'
            };
            
            return classMap[status] || 'badge badge-secondary';
        },
        formatDate(date) {
            if (!date) return '';
            const d = new Date(date);
            return d.toLocaleDateString('es-ES');
        },
        formatTime(time) {
            if (!time) return '';
            // Convertir formato "2023-01-01T09:00:00.000000Z" a "09:00"
            const match = time.match(/T(\d{2}:\d{2})/);
            return match ? match[1] : time;
        }
    }
}
</script>

<style scoped>
.time-slots-container {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 4px;
}
.time-slot {
    font-size: 0.9rem;
    padding: 6px;
}
.time-slot.active {
    background-color: #007bff;
    color: white;
}
.time-slot.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
.el-select, .el-date-editor {
    width: 100% !important;
}
</style>