<template>
    <el-dialog
        :visible="showDialog"
        @close="closeDialog"
        title="Detalles de la Cita"
        width="50%"
        append-to-body
    >
        <div v-if="appointment" class="appointment-details">
            <div class="row">
                <div class="col-md-6">
                    <h6>Información del Cliente</h6>
                    <p><strong>Nombre:</strong> {{ appointment.client ? appointment.client.name : 'N/A' }}</p>
                    <p v-if="appointment.client && appointment.client.telephone">
                        <strong>Teléfono:</strong> {{ appointment.client.telephone }}
                    </p>
                    <p v-if="appointment.client && appointment.client.email">
                        <strong>Email:</strong> {{ appointment.client.email }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h6>Información de la Cita</h6>
                    <p><strong>Fecha:</strong> {{ formatDate(appointment.appointment_date) }}</p>
                    <p><strong>Hora:</strong> {{ appointment.start_time }} - {{ appointment.end_time }}</p>
                    <p><strong>Estilista:</strong> {{ appointment.user ? appointment.user.name : 'N/A' }}</p>
                    <p><strong>Servicio:</strong> {{ appointment.service ? appointment.service.description : 'N/A' }}</p>
                    <p><strong>Estado:</strong> 
                        <span :class="getStatusBadgeClass(appointment.status)">
                            {{ getStatusText(appointment.status) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="row mt-3" v-if="appointment.notes">
                <div class="col-12">
                    <h6>Notas</h6>
                    <p>{{ appointment.notes }}</p>
                </div>
            </div>
            
            <div class="row mt-4" v-if="appointment.status === 'scheduled'">
                <div class="col-12 d-flex justify-content-end">
                    <button 
                        class="btn btn-success mr-2" 
                        @click="changeStatus('completed')"
                    >
                        <i class="fas fa-check mr-1"></i> Marcar como Completada
                    </button>
                    <button 
                        class="btn btn-danger mr-2" 
                        @click="changeStatus('cancelled')"
                    >
                        <i class="fas fa-times mr-1"></i> Cancelar Cita
                    </button>
                    <button 
                        class="btn btn-warning" 
                        @click="changeStatus('no_show')"
                    >
                        <i class="fas fa-user-slash mr-1"></i> No Asistió
                    </button>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import moment from 'moment';

export default {
    props: {
        showDialog: {
            type: Boolean,
            required: true
        },
        appointment: {
            type: Object,
            default: null
        }
    },
    methods: {
        formatDate(date) {
            if (!date) return '';
            return moment(date).format('DD/MM/YYYY');
        },
        getStatusText(status) {
            const statusMap = {
                'scheduled': 'Programada',
                'completed': 'Completada',
                'cancelled': 'Cancelada',
                'no_show': 'No asistió'
            };
            
            return statusMap[status] || status;
        },
        getStatusBadgeClass(status) {
            const classMap = {
                'scheduled': 'badge badge-primary',
                'completed': 'badge badge-success',
                'cancelled': 'badge badge-danger',
                'no_show': 'badge badge-warning'
            };
            
            return classMap[status] || 'badge badge-secondary';
        },
        async changeStatus(newStatus) {
            try {
                const response = await this.$http.put(`/caja/estilista/appointments/${this.appointment.id}/status`, {
                    status: newStatus
                });
                
                if (response.data.success) {
                    this.$message.success(response.data.message || 'Estado actualizado con éxito');
                    this.$emit('status-changed', {
                        appointmentId: this.appointment.id,
                        newStatus: newStatus
                    });
                    this.$emit('update:showDialog', false);
                } else {
                    this.$message.error(response.data.message || 'Error al actualizar estado');
                }
            } catch (error) {
                console.error('Error al cambiar estado:', error);
                this.$message.error('Error al actualizar estado');
            }
        },
        closeDialog() {
            this.$emit('update:showDialog', false);
        }
    }
};
</script>

<style scoped>
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