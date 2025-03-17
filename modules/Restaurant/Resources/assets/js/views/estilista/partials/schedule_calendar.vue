<template>
    <div class="calendar-container">
        <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary mr-2" @click="previousMonth">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h4 class="mb-0">{{ currentMonthName }} {{ currentYear }}</h4>
                <button class="btn btn-outline-secondary ml-2" @click="nextMonth">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div>
                <button class="btn btn-primary" @click="today">Hoy</button>
            </div>
        </div>

        <div class="calendar-view">
            <!-- Días de la semana -->
            <div class="calendar-days-header">
                <div class="calendar-day-header" v-for="day in daysOfWeek" :key="day">
                    {{ day }}
                </div>
            </div>

            <!-- Celdas del calendario -->
            <div class="calendar-grid">
                <div 
                    v-for="(day, index) in calendarDays" 
                    :key="index"
                    class="calendar-day"
                    :class="{
                        'other-month': !day.isCurrentMonth,
                        'today': day.isToday,
                        'has-appointments': day.appointments && day.appointments.length > 0,
                        'is-exception': day.exception,
                        'non-working-day': day.isNonWorkingDay
                    }"
                    @click="selectDay(day)"
                >
                    <div class="day-number">{{ day.day }}</div>
                    
                    <!-- Indicador de excepciones -->
                    <div v-if="day.exception" class="exception-indicator">
                        <i 
                            class="fas" 
                            :class="day.exception.is_working_day ? 'fa-check text-success' : 'fa-ban text-danger'"
                            :title="day.exception.is_working_day ? 'Día laborable (excepción)' : 'Día no laborable (excepción)'"
                        ></i>
                    </div>
                    
                    <!-- Indicador de citas -->
                    <div v-if="day.appointments && day.appointments.length > 0" class="appointment-count">
                        {{ day.appointments.length }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para ver detalles del día -->
        <el-dialog
            :title="selectedDate ? `Citas: ${formatDate(selectedDate)}` : 'Citas del día'"
            :visible.sync="showDayDetailsModal"
            width="700px"
        >
            <div v-if="selectedDay">
                <!-- Información del día -->
                <div class="day-info mb-3">
                    <div class="alert" :class="getDayStatusClass()">
                        <i class="fas" :class="getDayStatusIcon()"></i>
                        {{ getDayStatusText() }}
                        <span v-if="selectedDay.exception && selectedDay.exception.reason" class="ml-2">
                            - {{ selectedDay.exception.reason }}
                        </span>
                    </div>
                </div>

                <!-- Lista de citas -->
                <h5>Citas programadas</h5>
                <div v-if="!selectedDay.appointments || selectedDay.appointments.length === 0" class="alert alert-info">
                    No hay citas programadas para este día
                </div>
                <div v-else class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Horario</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="appointment in selectedDay.appointments" :key="appointment.id">
                                <td>{{ appointment.time_range }}</td>
                                <td>{{ appointment.client ? appointment.client.name : '-' }}</td>
                                <td>
                                    <span :class="getStatusBadgeClass(appointment.status)">
                                        {{ getStatusText(appointment.status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button 
                                            class="btn btn-info btn-sm" 
                                            @click="viewAppointment(appointment)"
                                            title="Ver detalles"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button 
                                            class="btn btn-primary btn-sm" 
                                            @click="editAppointment(appointment)"
                                            title="Editar"
                                            :disabled="appointment.status === 'cancelled' || appointment.status === 'completed'"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Botón para agregar cita -->
                <div class="text-center mt-3">
                    <button class="btn btn-success" @click="addAppointment">
                        <i class="fas fa-plus mr-1"></i> Agregar Cita
                    </button>
                </div>
            </div>
        </el-dialog>

        <!-- Modal para ver detalles de cita -->
        <el-dialog
            title="Detalles de la Cita"
            :visible.sync="showAppointmentDetailsModal"
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
                <el-button @click="showAppointmentDetailsModal = false">Cerrar</el-button>
                <el-button 
                    type="primary" 
                    @click="editAppointment(selectedAppointment)"
                    v-if="selectedAppointment && selectedAppointment.status === 'scheduled'"
                >
                    Editar
                </el-button>
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
            currentDate: new Date(),
            currentMonth: new Date().getMonth(),
            currentYear: new Date().getFullYear(),
            daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            calendarDays: [],
            appointments: [],
            exceptions: [],
            workingDays: [],
            selectedDay: null,
            selectedDate: null,
            showDayDetailsModal: false,
            selectedAppointment: null,
            showAppointmentDetailsModal: false
        }
    },
    computed: {
        currentMonthName() {
            const months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            return months[this.currentMonth];
        }
    },
    watch: {
        userId: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.loadData();
                } else {
                    this.appointments = [];
                    this.exceptions = [];
                    this.workingDays = [];
                    this.generateCalendar();
                }
            }
        },
        currentMonth() {
            this.generateCalendar();
        },
        currentYear() {
            this.generateCalendar();
        }
    },
    methods: {
        async loadData() {
            if (!this.userId) return;
            
            try {
                // Cargar citas del mes
                const startDate = new Date(this.currentYear, this.currentMonth, 1);
                const endDate = new Date(this.currentYear, this.currentMonth + 1, 0);
                
                const formattedStartDate = this.formatDateForApi(startDate);
                const formattedEndDate = this.formatDateForApi(endDate);
                
                const appointmentsResponse = await this.$http.get('/caja/estilista/appointments/records', {
                    params: {
                        user_id: this.userId,
                        start_date: formattedStartDate,
                        end_date: formattedEndDate
                    }
                });
                
                this.appointments = appointmentsResponse.data.data;
                
                // Cargar excepciones del mes
                const exceptionsResponse = await this.$http.get(`/caja/estilista/exceptions/records/${this.userId}`, {
                    params: {
                        start_date: formattedStartDate,
                        end_date: formattedEndDate
                    }
                });
                
                this.exceptions = exceptionsResponse.data.data;
                
                // Cargar días laborables
                const workingDaysResponse = await this.$http.get(`/caja/estilista/schedule-days/working-days/${this.userId}`);
                this.workingDays = workingDaysResponse.data.data;
                
                // Generar calendario con los datos cargados
                this.generateCalendar();
                
            } catch (error) {
                console.error('Error al cargar datos del calendario:', error);
                this.$message.error('Error al cargar datos del calendario');
            }
        },
        generateCalendar() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const daysInMonth = lastDay.getDate();
            
            // Obtener el día de la semana del primer día (0 = Domingo, 6 = Sábado)
            const firstDayOfWeek = firstDay.getDay();
            
            // Calcular días del mes anterior para completar la primera semana
            const daysFromPrevMonth = firstDayOfWeek;
            const prevMonth = this.currentMonth === 0 ? 11 : this.currentMonth - 1;
            const prevMonthYear = this.currentMonth === 0 ? this.currentYear - 1 : this.currentYear;
            const daysInPrevMonth = new Date(prevMonthYear, prevMonth + 1, 0).getDate();
            
            // Calcular días del mes siguiente para completar la última semana
            const daysFromNextMonth = (Math.ceil((daysInMonth + firstDayOfWeek) / 7) * 7) - (daysInMonth + firstDayOfWeek);
            
            // Generar array de días para el calendario
            const calendarDays = [];
            
            // Días del mes anterior
            for (let i = daysInPrevMonth - daysFromPrevMonth + 1; i <= daysInPrevMonth; i++) {
                const date = new Date(prevMonthYear, prevMonth, i);
                calendarDays.push(this.createDayObject(date, false));
            }
            
            // Días del mes actual
            for (let i = 1; i <= daysInMonth; i++) {
                const date = new Date(this.currentYear, this.currentMonth, i);
                calendarDays.push(this.createDayObject(date, true));
            }
            
            // Días del mes siguiente
            const nextMonth = this.currentMonth === 11 ? 0 : this.currentMonth + 1;
            const nextMonthYear = this.currentMonth === 11 ? this.currentYear + 1 : this.currentYear;
            
            for (let i = 1; i <= daysFromNextMonth; i++) {
                const date = new Date(nextMonthYear, nextMonth, i);
                calendarDays.push(this.createDayObject(date, false));
            }
            
            this.calendarDays = calendarDays;
        },
        createDayObject(date, isCurrentMonth) {
            const today = new Date();
            const isToday = date.getDate() === today.getDate() && 
                           date.getMonth() === today.getMonth() && 
                           date.getFullYear() === today.getFullYear();
            
            const formattedDate = this.formatDateForApi(date);
            
            // Buscar citas para este día
            const dayAppointments = this.appointments.filter(a => a.appointment_date === formattedDate);
            
            // Buscar excepciones para este día
            const exception = this.exceptions.find(e => e.exception_date === formattedDate);
            
            // Determinar si es día laborable
            let isNonWorkingDay = false;
            
            if (exception) {
                isNonWorkingDay = !exception.is_working_day;
            } else {
                // Verificar si el día de la semana es laborable según la configuración
                const dayOfWeek = date.getDay(); // 0 = Domingo, 6 = Sábado
                isNonWorkingDay = !this.workingDays.includes(dayOfWeek);
            }
            
            return {
                date: date,
                day: date.getDate(),
                month: date.getMonth(),
                year: date.getFullYear(),
                isCurrentMonth: isCurrentMonth,
                isToday: isToday,
                appointments: dayAppointments,
                exception: exception,
                isNonWorkingDay: isNonWorkingDay
            };
        },
        previousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
            this.loadData();
        },
        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
            this.loadData();
        },
        today() {
            const today = new Date();
            this.currentMonth = today.getMonth();
            this.currentYear = today.getFullYear();
            this.loadData();
        },
        selectDay(day) {
            this.selectedDay = day;
            this.selectedDate = day.date;
            this.showDayDetailsModal = true;
        },
        viewAppointment(appointment) {
            this.selectedAppointment = appointment;
            this.showAppointmentDetailsModal = true;
        },
        editAppointment(appointment) {
            this.showDayDetailsModal = false;
            this.showAppointmentDetailsModal = false;
            this.$emit('edit-appointment', appointment);
        },
        addAppointment() {
            this.showDayDetailsModal = false;
            this.$emit('add-appointment', this.formatDateForApi(this.selectedDate));
        },
        getDayStatusClass() {
            if (this.selectedDay.exception) {
                return this.selectedDay.exception.is_working_day ? 'alert-success' : 'alert-danger';
            }
            return this.selectedDay.isNonWorkingDay ? 'alert-warning' : 'alert-info';
        },
        getDayStatusIcon() {
            if (this.selectedDay.exception) {
                return this.selectedDay.exception.is_working_day ? 'fa-check' : 'fa-ban';
            }
            return this.selectedDay.isNonWorkingDay ? 'fa-calendar-times' : 'fa-calendar-check';
        },
        getDayStatusText() {
            if (this.selectedDay.exception) {
                return this.selectedDay.exception.is_working_day 
                    ? 'Día laborable (excepción)' 
                    : 'Día no laborable (excepción)';
            }
            return this.selectedDay.isNonWorkingDay ? 'Día no laborable' : 'Día laborable';
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
        formatDateForApi(date) {
            if (!date) return '';
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    }
}
</script>

<style scoped>
.calendar-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.calendar-days-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    font-weight: bold;
    margin-bottom: 10px;
    background-color: #f8f9fa;
    border-radius: 4px;
}

.calendar-day-header {
    padding: 10px;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    grid-gap: 5px;
}

.calendar-day {
    position: relative;
    height: 80px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.calendar-day:hover {
    background-color: #f0f7ff;
}

.calendar-day.other-month {
    opacity: 0.5;
}

.calendar-day.today {
    border: 2px solid #007bff;
}

.calendar-day.has-appointments {
    background-color: #e6f7ff;
}

.calendar-day.is-exception.non-working-day {
    background-color: #ffe6e6;
}

.calendar-day.is-exception:not(.non-working-day) {
    background-color: #e6ffe6;
}

.calendar-day.non-working-day:not(.is-exception) {
    background-color: #f8f9fa;
}

.day-number {
    font-weight: bold;
    margin-bottom: 5px;
}

.appointment-count {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background-color: #007bff;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.exception-indicator {
    position: absolute;
    top: 5px;
    right: 5px;
}
</style> 