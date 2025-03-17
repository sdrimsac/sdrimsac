<template>
    <el-dialog
        :title="schedule ? 'Editar Horario' : 'Nuevo Horario'"
        :visible.sync="showDialog"
        width="500px"
        @close="closeDialog"
    >
        <div class="form">
            <div class="form-group">
                <label for="name">Nombre del Horario:</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    v-model="form.name" 
                    placeholder="Ej: Horario de Verano"
                    required
                >
            </div>
            <div class="form-group">
                <el-switch v-model="form.is_active" active-text="Activo" inactive-text="Inactivo"></el-switch>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="closeDialog">Cancelar</el-button>
            <el-button type="primary" @click="submit" :loading="loading">
                {{ schedule ? 'Actualizar' : 'Guardar' }}
            </el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: {
        userId: {
            type: [Number, String],
            required: true
        },
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
            form: {
                name: '',
                is_active: true
            }
        }
    },
    watch: {
        show(val) {
            this.showDialog = val;
            if (val) {
                this.initForm();
            }
        }
    },
    methods: {
        loadRecords() {
            this.initForm();
        },
        initForm() {
            if (this.schedule) {
                this.form.name = this.schedule.name;
                this.form.is_active = this.schedule.is_active;
            } else {
                this.form.name = '';
                this.form.is_active = true;
            }
        },
        closeDialog() {
            this.$emit('close');
        },
        async submit() {
            if (!this.form.name) {
                this.$message.warning('Por favor ingrese un nombre para el horario');
                return;
            }
            
            this.loading = true;
            try {
                this.form.user_id = this.userId;
                let response;
                if (this.schedule) {
                    response = await this.$http.put(`/caja/estilista/schedules/${this.schedule.id}`, this.form);
                } else {
                    response = await this.$http.post('/caja/estilista/schedules', this.form);
                }
                
                if (response.data.success) {
                    this.$message.success(response.data.message);
                    this.$emit('saved');
                } else {
                    this.$message.error(response.data.message || 'Error al guardar horario');
                }
            } catch (error) {
                console.error('Error al guardar horario:', error);
                this.$message.error('Error al guardar horario');
            } finally {
                this.loading = false;
            }
        }
    }
}
</script> 