<template>
    <el-dialog
        :title="`Días de Horario: ${schedule ? schedule.name : ''}`"
        :visible.sync="showDialog"
        width="800px"
        @close="closeDialog"
    >
        <div class="row">
            <div class="col-md-6">
                <h5>Días de la Semana</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>Día</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="loading">
                                <td colspan="3" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Cargando...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else-if="days.length === 0">
                                <td colspan="3" class="text-center">No hay días configurados</td>
                            </tr>
                            <tr v-for="day in days" :key="day.id">
                                <td>{{ getDayName(day.day_of_week) }}</td>
                                <td>
                                    <span 
                                        :class="day.is_working_day ? 'badge badge-success' : 'badge badge-danger'"
                                    >
                                        {{ day.is_working_day ? 'Laborable' : 'No Laborable' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button 
                                            class="btn btn-info btn-sm" 
                                            @click="viewTimeSlots(day)"
                                            title="Ver horarios"
                                        >
                                            <i class="fas fa-clock"></i>
                                        </button>
                                        <button 
                                            class="btn btn-primary btn-sm" 
                                            @click="editDay(day)"
                                            title="Editar"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <h5>Configuración Rápida</h5>
                <div class="calendar-wrapper p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-group mb-0">
                            <div class="custom-control custom-switch">
                                <input 
                                    type="checkbox" 
                                    class="custom-control-input" 
                                    id="is_working_day" 
                                    v-model="quickForm.is_working_day"
                                >
                                <label class="custom-control-label" for="is_working_day">
                                    {{ quickForm.is_working_day ? 'Día Laborable' : 'Día No Laborable' }}
                                </label>
                            </div>
                        </div>
                        <button 
                            class="btn btn-primary btn-sm" 
                            @click="applyToSelected"
                            :disabled="selectedDays.length === 0"
                        >
                            Aplicar a seleccionados
                        </button>
                    </div>
                    <div class="calendar-days">
                        <div class="row mb-2">
                            <div 
                                v-for="day in weekDays" 
                                :key="day.value"
                                class="col text-center"
                            >
                                <strong>{{ day.label }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div 
                                v-for="day in weekDays" 
                                :key="day.value"
                                class="col text-center"
                            >
                                <div 
                                    class="day-selector p-2 rounded"
                                    :class="{
                                        'selected': selectedDays.includes(day.value),
                                        'working-day': isDayWorking(day.value),
                                        'non-working-day': !isDayWorking(day.value)
                                    }"
                                    @click="toggleDaySelection(day.value)"
                                >
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal para editar día -->
        <el-dialog
            title="Editar Día"
            :visible.sync="showDayDialog"
            width="400px"
            append-to-body
        >
            <div class="form">
                <div class="form-group">
                    <label>Día de la semana:</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        :value="selectedDay ? getDayName(selectedDay.day_of_week) : ''" 
                        readonly
                    >
                </div>
                <div class="form-group">
                    <div class="d-flex align-items-center">
                        <span class="mr-2">{{ dayForm.is_working_day ? 'Día Laborable' : 'Día No Laborable' }}</span>
                        <div class="custom-control custom-switch">
                            <input 
                                type="checkbox" 
                                class="custom-control-input" 
                                id="day_is_working" 
                                v-model="dayForm.is_working_day"
                            >
                            <label class="custom-control-label" for="day_is_working"></label>
                        </div>
                    </div>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showDayDialog = false">Cancelar</el-button>
                <el-button type="primary" @click="saveDay" :loading="savingDay">
                    Guardar
                </el-button>
            </span>
        </el-dialog>
        
        <!-- Modal para ver/editar slots de tiempo -->
        <el-dialog
            :title="`Horarios para ${selectedDay ? getDayName(selectedDay.day_of_week) : ''}`"
            :visible.sync="showTimeSlotsDialog"
            width="700px"
            append-to-body
        >
            <div class="mb-3">
                <button class="btn btn-success" @click="addTimeSlot">
                    <i class="fas fa-plus mr-1"></i> Agregar Franja Horaria
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>Horario</th>
                            <th>Duración</th>
                            <th>Descanso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loadingTimeSlots">
                            <td colspan="5" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Cargando...</span>
                                </div>
                            </td>
                        </tr>
                        <tr v-else-if="timeSlots.length === 0">
                            <td colspan="5" class="text-center">No hay franjas horarias configuradas</td>
                        </tr>
                        <tr v-for="slot in timeSlots" :key="slot.id">
                            <td>{{ formatTime(slot.start_time) }} - {{ formatTime(slot.end_time) }}</td>
                            <td>{{ slot.slot_duration }} min</td>
                            <td>{{ slot.break_between_slots }} min</td>
                            <td>
                                <span 
                                    :class="slot.is_active ? 'badge badge-success' : 'badge badge-danger'"
                                >
                                    {{ slot.is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button 
                                        class="btn btn-primary btn-sm" 
                                        @click="editTimeSlot(slot)"
                                        title="Editar"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button 
                                        class="btn btn-danger btn-sm" 
                                        @click="deleteTimeSlot(slot.id)"
                                        title="Eliminar"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Modal para agregar/editar franja horaria -->
            <el-dialog
                :title="selectedTimeSlot ? 'Editar Franja Horaria' : 'Nueva Franja Horaria'"
                :visible.sync="showAddTimeSlotForm"
                width="500px"
                append-to-body
            >
                <div class="form">
                    <div class="form-group">
                        <label for="start_time">Hora de inicio:</label>
                        <input 
                            type="time" 
                            class="form-control" 
                            id="start_time" 
                            v-model="timeSlotForm.start_time"
                        >
                    </div>
                    <div class="form-group">
                        <label for="end_time">Hora de fin:</label>
                        <input 
                            type="time" 
                            class="form-control" 
                            id="end_time" 
                            v-model="timeSlotForm.end_time"
                        >
                    </div>
                    <div class="form-group">
                        <label for="slot_duration">Duración de cada cita (minutos):</label>
                        <input 
                            type="number" 
                            class="form-control" 
                            id="slot_duration" 
                            v-model.number="timeSlotForm.slot_duration"
                            min="5"
                        >
                    </div>
                    <div class="form-group">
                        <label for="break_between_slots">Descanso entre citas (minutos):</label>
                        <input 
                            type="number" 
                            class="form-control" 
                            id="break_between_slots" 
                            v-model.number="timeSlotForm.break_between_slots"
                            min="0"
                        >
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input 
                                type="checkbox" 
                                class="custom-control-input" 
                                id="is_active_slot" 
                                v-model="timeSlotForm.is_active"
                            >
                            <label class="custom-control-label" for="is_active_slot">
                                {{ timeSlotForm.is_active ? 'Franja Activa' : 'Franja Inactiva' }}
                            </label>
                        </div>
                    </div>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="showAddTimeSlotForm = false">Cancelar</el-button>
                    <el-button type="primary" @click="saveTimeSlot" :loading="savingTimeSlot">
                        {{ selectedTimeSlot ? 'Actualizar' : 'Guardar' }}
                    </el-button>
                </span>
            </el-dialog>
        </el-dialog>
        
        <span slot="footer" class="dialog-footer">
            <el-button @click="closeDialog">Cerrar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            default: false
        },
        schedule: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            showDialog: false,
            loading: false,
            days: [],
            weekDays: [
                { label: 'Dom', value: 0 },
                { label: 'Lun', value: 1 },
                { label: 'Mar', value: 2 },
                { label: 'Mié', value: 3 },
                { label: 'Jue', value: 4 },
                { label: 'Vie', value: 5 },
                { label: 'Sáb', value: 6 }
            ],
            selectedDays: [],
            quickForm: {
                is_working_day: true
            },
            showDayDialog: false,
            selectedDay: null,
            dayForm: {
                is_working_day: true
            },
            savingDay: false,
            showTimeSlotsDialog: false,
            loadingTimeSlots: false,
            timeSlots: [],
            showAddTimeSlotForm: false,
            selectedTimeSlot: null,
            timeSlotForm: {
                user_schedule_day_id: null,
                start_time: '',
                end_time: '',
                slot_duration: 60,
                break_between_slots: 0,
                is_active: true
            },
            savingTimeSlot: false
        }
    },
    watch: {
        show(val) {
            this.showDialog = val;
            if (val && this.schedule) {
                this.loadDays();
            }
        }
    },
    methods: {
        closeDialog() {
            this.$emit('close');
        },
        async loadDays() {
            if (!this.schedule) return;
            
            this.loading = true;
            try {
                const response = await this.$http.get(`/caja/estilista/schedule-days/records/${this.schedule.id}`);
                this.days = response.data.data;
            } catch (error) {
                console.error('Error al cargar días:', error);
                this.$message.error('No se pudieron cargar los días');
            } finally {
                this.loading = false;
            }
        },
        getDayName(dayOfWeek) {
            const days = [
                'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'
            ];
            return days[dayOfWeek];
        },
        isDayWorking(dayOfWeek) {
            const day = this.days.find(d => d.day_of_week === dayOfWeek);
            return day ? day.is_working_day : false;
        },
        toggleDaySelection(dayOfWeek) {
            const index = this.selectedDays.indexOf(dayOfWeek);
            if (index === -1) {
                this.selectedDays.push(dayOfWeek);
            } else {
                this.selectedDays.splice(index, 1);
            }
        },
        async applyToSelected() {
            if (this.selectedDays.length === 0) return;
            
            try {
                for (const dayOfWeek of this.selectedDays) {
                    const existingDay = this.days.find(d => d.day_of_week === dayOfWeek);
                    
                    if (existingDay) {
                        // Actualizar día existente
                        await this.$http.put(`/caja/estilista/schedule-days/${existingDay.id}`, {
                            is_working_day: this.quickForm.is_working_day
                        });
                    } else {
                        // Crear nuevo día
                        await this.$http.post('/caja/estilista/schedule-days', {
                            user_schedule_id: this.schedule.id,
                            day_of_week: dayOfWeek,
                            is_working_day: this.quickForm.is_working_day
                        });
                    }
                }
                
                this.$message.success('Días actualizados correctamente');
                this.loadDays();
                this.selectedDays = [];
            } catch (error) {
                console.error('Error al actualizar días:', error);
                this.$message.error('Error al actualizar días');
            }
        },
        editDay(day) {
            this.selectedDay = day;
            this.dayForm.is_working_day = day.is_working_day;
            this.showDayDialog = true;
        },
        async saveDay() {
            if (!this.selectedDay) return;
            
            this.savingDay = true;
            try {
                const response = await this.$http.put(`/caja/estilista/schedule-days/${this.selectedDay.id}`, {
                    day_of_week: this.selectedDay.day_of_week,
                    is_working_day: this.dayForm.is_working_day
                });
                
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.showDayDialog = false;
                    this.loadDays();
                } else {
                    this.$message.error(response.data.message || 'Error al guardar día');
                }
            } catch (error) {
                console.error('Error al guardar día:', error);
                this.$message.error('Error al guardar día');
            } finally {
                this.savingDay = false;
            }
        },
        async viewTimeSlots(day) {
            this.selectedDay = day;
            this.showTimeSlotsDialog = true;
            await this.loadTimeSlots(day.id);
        },
        async loadTimeSlots(dayId) {
            this.loadingTimeSlots = true;
            try {
                const response = await this.$http.get(`/caja/estilista/time-slots/records/${dayId}`);
                this.timeSlots = response.data.data;
            } catch (error) {
                console.error('Error al cargar franjas horarias:', error);
                this.$message.error('No se pudieron cargar las franjas horarias');
            } finally {
                this.loadingTimeSlots = false;
            }
        },
        addTimeSlot() {
            this.selectedTimeSlot = null;
            this.timeSlotForm = {
                user_schedule_day_id: this.selectedDay.id,
                start_time: '09:00',
                end_time: '18:00',
                slot_duration: 60,
                break_between_slots: 0,
                is_active: true
            };
            this.showAddTimeSlotForm = true;
        },
        editTimeSlot(slot) {
            this.selectedTimeSlot = slot;
            this.timeSlotForm = {
                user_schedule_day_id: slot.user_schedule_day_id,
                start_time: this.formatTime(slot.start_time),
                end_time: this.formatTime(slot.end_time),
                slot_duration: slot.slot_duration,
                break_between_slots: slot.break_between_slots,
                is_active: slot.is_active
            };
            this.showAddTimeSlotForm = true;
        },
        async saveTimeSlot() {
            if (!this.timeSlotForm.start_time || !this.timeSlotForm.end_time) {
                this.$message.warning('Por favor complete todos los campos');
                return;
            }
            
            if (this.timeSlotForm.start_time >= this.timeSlotForm.end_time) {
                this.$message.warning('La hora de inicio debe ser anterior a la hora de fin');
                return;
            }
            
            this.savingTimeSlot = true;
            try {
                let response;
                if (this.selectedTimeSlot) {
                    response = await this.$http.put(`/caja/estilista/time-slots/${this.selectedTimeSlot.id}`, this.timeSlotForm);
                } else {
                    response = await this.$http.post('/caja/estilista/time-slots', this.timeSlotForm);
                }
                
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.showAddTimeSlotForm = false;
                    this.loadTimeSlots(this.selectedDay.id);
                } else {
                    this.$message.error(response.data.message || 'Error al guardar franja horaria');
                }
            } catch (error) {
                console.error('Error al guardar franja horaria:', error);
                this.$message.error('Error al guardar franja horaria');
            } finally {
                this.savingTimeSlot = false;
            }
        },
        async deleteTimeSlot(id) {
            this.$confirm('¿Está seguro de eliminar esta franja horaria? Esta acción no se puede deshacer.', 'Advertencia', {
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning'
            }).then(async () => {
                try {
                    const response = await this.$http.delete(`/caja/estilista/time-slots/${id}`);
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.loadTimeSlots(this.selectedDay.id);
                    } else {
                        this.$message.error(response.data.message || 'Error al eliminar franja horaria');
                    }
                } catch (error) {
                    console.error('Error al eliminar franja horaria:', error);
                    this.$message.error('Error al eliminar franja horaria');
                }
            }).catch(() => {
                // Cancelado
            });
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
.calendar-days .day-selector {
    cursor: pointer;
    border: 1px solid #ddd;
}
.calendar-days .day-selector:hover {
    background-color: #f8f9fa;
}
.calendar-days .day-selector.selected {
    border: 2px solid #007bff;
}
.calendar-days .day-selector.working-day {
    background-color: #d4edda;
}
.calendar-days .day-selector.non-working-day {
    background-color: #f8d7da;
}
</style> 