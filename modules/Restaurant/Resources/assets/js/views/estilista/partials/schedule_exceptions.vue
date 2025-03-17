<template>
    <div>
        <div class="mb-3">
            <button class="btn btn-success" @click="showAddExceptionModal = true" :disabled="!userId">
                <i class="fas fa-plus mr-1"></i> Agregar Excepción
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Horario</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="loading">
                        <td colspan="5" class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                        </td>
                    </tr>
                    <tr v-else-if="records.length === 0">
                        <td colspan="5" class="text-center">No hay excepciones registradas</td>
                    </tr>
                    <tr v-for="record in records" :key="record.id">
                        <td>{{ formatDate(record.exception_date) }}</td>
                        <td>
                            <span 
                                :class="record.is_working_day ? 'badge badge-success' : 'badge badge-danger'"
                            >
                                {{ record.is_working_day ? 'Laborable' : 'No Laborable' }}
                            </span>
                        </td>
                        <td>{{ record.is_working_day ? record.time_range : 'No disponible' }}</td>
                        <td>{{ record.reason || '-' }}</td>
                        <td>
                            <div class="btn-group">
                                <button 
                                    class="btn btn-primary btn-sm" 
                                    @click="editException(record)"
                                    title="Editar"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    class="btn btn-danger btn-sm" 
                                    @click="deleteException(record.id)"
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
        
        <!-- Modal para agregar/editar excepción -->
        <el-dialog
            :title="selectedException ? 'Editar Excepción' : 'Nueva Excepción'"
            :visible.sync="showAddExceptionModal"
            width="500px"
        >
            <div class="form">
                <div class="form-group">
                    <label for="exception_date">Fecha:</label>
                    <el-date-picker
                        v-model="form.exception_date"
                        type="date"
                        placeholder="Seleccione fecha"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                        class="w-100"
                    ></el-date-picker>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input 
                            type="checkbox" 
                            class="custom-control-input" 
                            id="is_working_day" 
                            v-model="form.is_working_day"
                        >
                        <label class="custom-control-label" for="is_working_day">
                            {{ form.is_working_day ? 'Día Laborable' : 'Día No Laborable' }}
                        </label>
                    </div>
                </div>
                <div v-if="form.is_working_day" class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_time">Hora de inicio:</label>
                            <input 
                                type="time" 
                                class="form-control" 
                                id="start_time" 
                                v-model="form.start_time"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_time">Hora de fin:</label>
                            <input 
                                type="time" 
                                class="form-control" 
                                id="end_time" 
                                v-model="form.end_time"
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="reason">Motivo:</label>
                    <textarea 
                        class="form-control" 
                        id="reason" 
                        v-model="form.reason" 
                        rows="3"
                        placeholder="Ej: Día festivo, Vacaciones, etc."
                    ></textarea>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showAddExceptionModal = false">Cancelar</el-button>
                <el-button type="primary" @click="saveException" :loading="saving">
                    {{ selectedException ? 'Actualizar' : 'Guardar' }}
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
            loading: false,
            records: [],
            showAddExceptionModal: false,
            selectedException: null,
            form: {
                user_id: null,
                exception_date: null,
                is_working_day: false,
                start_time: '09:00',
                end_time: '18:00',
                reason: ''
            },
            saving: false
        }
    },
    watch: {
        userId: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.loadRecords();
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
                const response = await this.$http.get(`/caja/estilista/exceptions/records/${this.userId}`);
                this.records = response.data.data;
            } catch (error) {
                console.error('Error al cargar excepciones:', error);
                this.$message.error('No se pudieron cargar las excepciones');
            } finally {
                this.loading = false;
            }
        },
        editException(exception) {
            this.selectedException = exception;
            this.form = {
                user_id: exception.user_id,
                exception_date: exception.exception_date,
                is_working_day: exception.is_working_day,
                start_time: this.formatTime(exception.start_time),
                end_time: this.formatTime(exception.end_time),
                reason: exception.reason
            };
            this.showAddExceptionModal = true;
        },
        async saveException() {
            if (!this.form.exception_date) {
                this.$message.warning('Por favor seleccione una fecha');
                return;
            }
            
            if (this.form.is_working_day && (!this.form.start_time || !this.form.end_time)) {
                this.$message.warning('Por favor complete el horario');
                return;
            }
            
            if (this.form.is_working_day && this.form.start_time >= this.form.end_time) {
                this.$message.warning('La hora de inicio debe ser anterior a la hora de fin');
                return;
            }
            
            this.form.user_id = this.userId;
            
            this.saving = true;
            try {
                let response;
                if (this.selectedException) {
                    response = await this.$http.put(`/caja/estilista/exceptions/${this.selectedException.id}`, this.form);
                } else {
                    response = await this.$http.post('/caja/estilista/exceptions', this.form);
                }
                
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.showAddExceptionModal = false;
                    this.loadRecords();
                } else {
                    this.$message.error(response.data.message || 'Error al guardar excepción');
                }
            } catch (error) {
                console.error('Error al guardar excepción:', error);
                this.$message.error('Error al guardar excepción');
            } finally {
                this.saving = false;
            }
        },
        async deleteException(id) {
            this.$confirm('¿Está seguro de eliminar esta excepción? Esta acción no se puede deshacer.', 'Advertencia', {
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning'
            }).then(async () => {
                try {
                    const response = await this.$http.delete(`/caja/estilista/exceptions/${id}`);
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.loadRecords();
                    } else {
                        this.$message.error(response.data.message || 'Error al eliminar excepción');
                    }
                } catch (error) {
                    console.error('Error al eliminar excepción:', error);
                    this.$message.error('Error al eliminar excepción');
                }
            }).catch(() => {
                // Cancelado
            });
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