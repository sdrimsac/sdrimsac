<template>
    <div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th class="text-white">Nombre</th>
                        <th class="text-white">Estado</th>
                        <th class="text-white">Acciones</th>
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
                    <tr v-else-if="records.length === 0">
                        <td colspan="3" class="text-center">No has creado ningún horario todavía</td>
                    </tr>
                    <tr v-for="record in records" :key="record.id">
                        <td>{{ record.name }}</td>
                        <td>
                            <span 
                                :class="{
                                
                                    'text-danger': !record.is_active
                                }"
                            >
                                {{ record.is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button 
                                    class="btn btn-info btn-sm" 
                                    @click="$emit('view-days', record)"
                                    title="Ver días"
                                >
                                    <i class="fas fa-calendar-day"></i>
                                </button>
                                <button 
                                    class="btn btn-primary btn-sm" 
                                    @click="$emit('edit-schedule', record)"
                                    title="Editar"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    class="btn btn-danger btn-sm" 
                                    @click="deleteSchedule(record.id)"
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            records: []
        }
    },
    mounted() {
        this.loadRecords();
    },
    methods: {
        async loadRecords() {
            this.loading = true;
            try {
                const response = await this.$http.get('/caja/estilista/schedules/records');
                this.records = response.data.data;
            } catch (error) {
                console.error('Error al cargar horarios:', error);
                this.$message.error('No se pudieron cargar los horarios');
            } finally {
                this.loading = false;
            }
        },
        async deleteSchedule(id) {
            this.$confirm('¿Está seguro de eliminar este horario? Esta acción no se puede deshacer.', 'Advertencia', {
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning'
            }).then(async () => {
                try {
                    const response = await this.$http.delete(`/caja/estilista/schedules/${id}`);
                    if (response.data.success) {
                        this.$message.success(response.data.message);
                        this.loadRecords();
                    } else {
                        this.$message.error(response.data.message || 'Error al eliminar horario');
                    }
                } catch (error) {
                    console.error('Error al eliminar horario:', error);
                    this.$message.error('Error al eliminar horario');
                }
            }).catch(() => {
                // Cancelado
            });
        }
    }
}
</script> 