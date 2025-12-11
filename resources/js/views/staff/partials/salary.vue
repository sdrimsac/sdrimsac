<template>
    <el-dialog :visible.sync="showDialog" width="700px" center :close-on-click-modal="false"
        :close-on-press-escape="false" :show-close="true" append-to-body title="Salarios del Personal">

        <div class="salary-dialog">
            <div class="card">
                <div class="card-body">
                    <el-form :model="form" label-width="140px" class="salary-form" @submit.native.prevent>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Tipo de trabajador</label>
                                <el-select v-model="form.name" placeholder="Seleccione tipo de trabajador">
                                    <el-option label="ADMINISTRADOR(A)" value="ADMINISTRADOR(A)"></el-option>
                                    <el-option label="CAJERO(A)" value="CAJERO(A)"></el-option>
                                    <el-option label="MOZO(A)" value="MOZO(A)"></el-option>
                                    <el-option label="COCINERO(A)" value="COCINERO(A)"></el-option>
                                </el-select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Sueldo base</label>
                                <el-input v-model="form.sueldo_base" placeholder="Sueldo base"></el-input>
                            </div>
                            <div class="col-md-4">
                                <label for="">Factor diario</label>
                                <el-input v-model="form.factor_diario" placeholder="Factor diario"></el-input>
                            </div>
                        </div>
                        <div class="form-actions" style="text-align: right; margin-top: 8px;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <el-button class="btn_cancelarsmall" type="danger" round @click="$emit('update:showDialog', false)">
                                    Cancelar
                                </el-button>
                                <el-button class="btn_guardarsmall" type="primary" round :loading="loading" @click="addRecord">
                                    {{ form.id ? 'Guardar' : 'Agregar' }}
                                </el-button>
                            </div>
                        </div>
                    </el-form>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-white text-center">Tipo de trabajador</th>
                                <th class="text-white text-center">Sueldo base</th>
                                <th class="text-white text-center">Factor diario</th>
                                <th class="text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(record, index) in records" :key="record.id || index" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }"
 >
                                <td>{{ record.name ? record.name.toUpperCase() : '' }}</td>
                                <td class="text-center">{{ formatCurrency(null, null, record.sueldo_base) }}</td>
                                <td class="text-right">{{ formatCurrency(null, null, record.factor_diario) }}</td>
                                <td text="center">
                                    <el-button type="primary" icon="el-icon-edit" circle
                                        @click="editRecord(record)"></el-button>
                                    <el-button type="danger" icon="el-icon-delete" circle
                                        @click="deleteRecord(record)"></el-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: {
        showDialog: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            records: [],
            loading: false,
            form: {
                id: null,
                name: '',
                sueldo_base: null,
                factor_diario: null
            }
        };
    },
    watch: {
        // Cuando el modal se abre (showDialog pasa a true) cargamos los registros
        showDialog(newVal) {
            if (newVal) {
                this.getData();
            } else {
                // limpiar formulario al cerrar
                this.resetForm();
            }
        }
    },
    methods: {

        getData() {
            this.loading = true;
            // Usamos el cliente HTTP global ($http) consistente con el resto del proyecto
            this.$http.get('job_positions/records')
                .then(response => {
                    // Almacenar registros recibidos
                    this.records = response.data.data || response.data || [];
                    // normalizar números si vienen como strings
                    this.records = this.records.map(r => ({
                        ...r,
                        sueldo_base: r.sueldo_base != null ? Number(r.sueldo_base) : r.sueldo_base,
                        factor_diario: r.factor_diario != null ? Number(r.factor_diario) : r.factor_diario
                    }));
                    console.log('job_positions records', this.records);
                })
                .catch(error => {
                    console.error('Error obteniendo job_positions records', error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        addRecord() {
            // Validación básica
            if (!this.form.name || this.form.sueldo_base === null || this.form.sueldo_base === '') {
                this.$message.warning('Complete el nombre y el sueldo base');
                return;
            }

            const payload = {
                name: this.form.name,
                sueldo_base: this.form.sueldo_base,
                factor_diario: this.form.factor_diario
            };

            this.loading = true;

            // Si existe form.id => actualizar, si no => crear
            if (this.form.id) {
                const id = this.form.id;
                this.$http.put(`job_positions/${id}`, payload)
                    .then(() => {
                        this.$message.success('Registro actualizado');
                        this.getData();
                        this.resetForm();
                    })
                    .catch(err => {
                        console.error('Error actualizando job_positions record', err);
                        this.$message.error('No se pudo actualizar el registro en el servidor');
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                // Crear nuevo registro
                this.$http.post('job_positions', payload)
                    .then(() => {
                        this.$message.success('Registro agregado');
                        this.getData();
                        this.resetForm();
                    })
                    .catch(err => {
                        console.warn('No se pudo guardar en API, guardando localmente', err);
                        this.records.push(Object.assign({ id: null }, payload));
                        this.$message.success('Registro agregado (local)');
                        this.resetForm();
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },

        editRecord(row) {
            // Cargar datos en el formulario para edición (simple)
            this.form = Object.assign({}, row);
            // Abrir el diálogo si está cerrado (por si se usa desde fuera)
            if (!this.showDialog) this.$emit('update:showDialog', true);
        },

        deleteRecord(record) {
            // record debe ser un objeto con al menos { id, name }
            if (!record || !record.id) {
                this.$message.error('Registro no encontrado');
                return;
            }

            // Confirmación antes de eliminar
            this.$confirm(`¿Desea eliminar el registro "${record.name}"?`, 'Confirmar eliminación', {
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                type: 'warning'
            }).then(() => {
                this.loading = true;
                const idToDelete = record.id;

                this.$http.delete(`job_positions/${idToDelete}`)
                    .then(() => {
                        // Eliminar localmente sólo tras confirmación del servidor
                        const idx = this.records.findIndex(r => r.id === idToDelete);
                        if (idx !== -1) this.records.splice(idx, 1);
                        this.$message.success('Registro eliminado');
                    })
                    .catch(err => {
                        // No eliminar localmente si hay error; informar al usuario
                        const status = err && err.response && err.response.status;
                        if (status === 404 || status === 410) {
                            this.$message.error('No se encontró el registro en el servidor. No se eliminará localmente.');
                            return;
                        }

                        console.error('Error eliminando job_positions record', err);
                        this.$message.error('No se pudo eliminar el registro en el servidor');
                    })
                    .finally(() => {
                        this.loading = false;
                    });

            }).catch(() => {
                // Usuario canceló la acción; no hacer nada
            });
        },

        resetForm() {
            this.form = { id: null, name: '', sueldo_base: null, factor_diario: null };
        },

        formatCurrency(row, column, cellValue) {
            const value = cellValue != null ? Number(cellValue) : null;
            if (value == null || Number.isNaN(value)) return '-';
            return value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }
};
</script>