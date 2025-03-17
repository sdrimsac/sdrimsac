<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="my-0 text-white">Gestión de Mi Horario de Atención</h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Bienvenido a la gestión de tu horario de atención. Aquí podrás configurar tus días y horas de trabajo.
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <button 
                            class="btn btn-primary mr-2" 
                            @click="createDefaultSchedule" 
                            :disabled="loadingDefault"
                        >
                            <i class="fas fa-calendar-plus mr-1"></i>
                            {{ loadingDefault ? 'Creando...' : 'Crear Horario Predeterminado' }}
                        </button>
                        <button 
                            class="btn btn-success" 
                            @click="showCreateScheduleModal = true"
                        >
                            <i class="fas fa-plus mr-1"></i>
                            Nuevo Horario
                        </button>
                    </div>
                </div>

                <el-tabs v-model="activeTab" type="card">
                    <el-tab-pane label="Horarios" name="schedules">
                        <schedule-list 
                            :user-id="currentUser.id"
                            ref="scheduleList"
                            @edit-schedule="editSchedule"
                            @view-days="viewScheduleDays"
                        />
                    </el-tab-pane>
                    <el-tab-pane label="Excepciones" name="exceptions">
                        <schedule-exceptions 
                            :user-id="currentUser.id"
                            ref="scheduleExceptions"
                        />
                    </el-tab-pane>
                    <el-tab-pane label="Citas" name="appointments">
                        <schedule-appointments 
                            :user-id="currentUser.id"
                            ref="appointmentsList"
                            @edit-appointment="editAppointment"
                        />
                    </el-tab-pane>
                    <el-tab-pane label="Calendario" name="calendar">
                        <schedule-calendar 
                            :user-id="currentUser.id"
                            ref="scheduleCalendar"
                            @edit-appointment="editAppointment"
                            @add-appointment="addAppointment"
                        />
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>

        <!-- Modal para crear/editar horario -->
        <schedule-form
            :user-id="currentUser.id"
            :show="showCreateScheduleModal"
            :schedule="selectedSchedule"
            @close="closeScheduleModal"
            @saved="onScheduleSaved"
        />

        <!-- Modal para configurar días de horario -->
        <schedule-days-form
            :user-id="currentUser.id"
            :show="showScheduleDaysModal"
            :schedule="selectedSchedule"
            @close="closeScheduleDaysModal"
            @saved="onScheduleDaysSaved"
        />
    </div>
</template>

<script>
import ScheduleList from './partials/schedule_list.vue'
import ScheduleForm from './partials/schedule_form.vue'
import ScheduleDaysForm from './partials/schedule_days_form.vue'
import ScheduleExceptions from './partials/schedule_exceptions.vue'
import ScheduleAppointments from './partials/schedule_appointments.vue'
import ScheduleCalendar from './partials/schedule_calendar.vue'

export default {
    components: {
        ScheduleList,
        ScheduleForm,
        ScheduleDaysForm,
        ScheduleExceptions,
        ScheduleAppointments,
        ScheduleCalendar
    },
    data() {
        return {
            activeTab: 'schedules',
            showCreateScheduleModal: false,
            showScheduleDaysModal: false,
            selectedSchedule: null,
            loadingDefault: false,
            currentUser: null
        }
    },
    created() {
        this.getCurrentUser();
    },
    methods: {
        async getCurrentUser() {
            try {
                const response = await this.$http.get('/caja/estilista/current-user');
                this.currentUser = response.data;
                this.loadUserData();
            } catch (error) {
                console.error('Error al obtener usuario actual:', error);
                this.$message.error('Error al cargar información del usuario');
            }
        },
        loadUserData() {
            if (this.$refs.scheduleList) {
                this.$refs.scheduleList.loadRecords();
            }
            if (this.$refs.scheduleExceptions) {
                this.$refs.scheduleExceptions.loadRecords();
            }
            if (this.$refs.appointmentsList) {
                this.$refs.appointmentsList.loadRecords();
            }
            if (this.$refs.scheduleCalendar) {
                this.$refs.scheduleCalendar.loadData();
            }
            if (this.$refs.scheduleForm) {
                this.$refs.scheduleForm.loadData();
            }

        },
        async createDefaultSchedule() {
            this.loadingDefault = true;
            try {
                const response = await this.$http.post('/caja/estilista/schedules/create-default');
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.loadUserData();
                } else {
                    this.$message.error(response.data.message || 'Error al crear horario predeterminado');
                }
            } catch (error) {
                console.error('Error al crear horario predeterminado:', error);
                this.$message.error('Error al crear horario predeterminado');
            } finally {
                this.loadingDefault = false;
            }
        },
        editSchedule(schedule) {
            this.selectedSchedule = schedule;
            this.showCreateScheduleModal = true;
        },
        viewScheduleDays(schedule) {
            this.selectedSchedule = schedule;
            this.showScheduleDaysModal = true;
        },
        closeScheduleModal() {
            this.showCreateScheduleModal = false;
            this.selectedSchedule = null;
        },
        closeScheduleDaysModal() {
            this.showScheduleDaysModal = false;
            this.selectedSchedule = null;
        },
        onScheduleSaved() {
            this.closeScheduleModal();
            this.loadUserData();
        },
        onScheduleDaysSaved() {
            this.closeScheduleDaysModal();
            this.loadUserData();
        },
        editAppointment(appointment) {
            if (this.$refs.appointmentsList) {
                this.$refs.appointmentsList.editAppointment(appointment);
                this.activeTab = 'appointments';
            }
        },
        addAppointment(date) {
            if (this.$refs.appointmentsList) {
                this.$refs.appointmentsList.addAppointment(date);
                this.activeTab = 'appointments';
            }
        }
    }
}
</script>

<style scoped>
tr.bg-secondary.text-white tr th {
    color: white !important;
}
.el-select {
    width: 100%;
}
</style>